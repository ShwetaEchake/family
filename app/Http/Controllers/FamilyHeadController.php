<?php

namespace App\Http\Controllers;

use App\Models\FamilyHead;
use App\Models\FamilyMember;
use App\Models\Hobby;
use App\Http\Requests\StoreFamilyHeadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;


class FamilyHeadController extends Controller
{
    /**
     * Display the list of family heads with member count.
     */
    public function index()
    {
        $familyHeads = FamilyHead::withCount('familyMembers')
            ->orderByDesc('created_at')
            ->paginate(10);


        return view('family.index', compact('familyHeads'));
    }

    /**
     * Show the form for creating a new family head.
     */
    public function create()
    {
        $states = $this->getStates();
        return view('family.create', compact('states'));
    }

    /**
     * Store a newly created family head in storage.
     */

    public function store(StoreFamilyHeadRequest $request)
    {
        DB::beginTransaction();

        try {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('family/heads', 'public');
            }

            $head = FamilyHead::create([
                'name'           => $request->name,
                'surname'        => $request->surname,
                'birthdate'      => $request->birthdate,
                'mobile_no'      => $request->mobile_no,
                'address'        => $request->address,
                'state'          => $request->state,
                'city'           => $request->city,
                'pincode'        => $request->pincode,
                'marital_status' => $request->marital_status,
                'wedding_date'   => $request->marital_status === 'married' ? $request->wedding_date : null,
                'photo'          => $photoPath,
            ]);

            if ($request->filled('hobbies')) {
                foreach (array_filter($request->hobbies) as $hobby) {
                    Hobby::create([
                        'family_head_id' => $head->id,
                        'hobby'          => $hobby,
                    ]);
                }
            }


            $input = $request->all();
            if(isset($input['member_name']))
            {
                foreach($input['member_name'] as $key => $member_name)
                {
                    if(empty($member_name))
                    {
                        continue;
                    }

                    $createData = new FamilyMember([
                        'name'             => $member_name,
                        'birthdate'        => $input['member_birthdate'][$key] ?? null,
                        'marital_status'   => $input['member_marital_status'][$key] ?? null,
                        'wedding_date'     => $input['member_wedding_date'][$key] ?? null,
                        'education'        => $input['education'][$key] ?? null,
                    ]);

                    if(
                        $request->hasFile('document') &&
                        isset($request->file('document')[$key]) &&
                        $request->file('document')[$key]->isValid()
                    ){
                        $document = $request->file('document')[$key];
                        $documentPath = $document->store('family/members', 'public');
                        $createData->photo = $documentPath;
                    }
                    $head->familyMembers()->save($createData);
                }
            }


            DB::commit();
            return response()->json(['success'=> 'Family Created successfully!']);


        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondWithAjax($e, 'adding', 'Family');
        }
    }

    /**
     * Show family head details with all members.
     */



    public function show(FamilyHead $familyHead)
    {
        $familyHead->load(['hobbies', 'familyMembers']);

        $html = '

        <div class="row">

                <div class="col-md-12 text-center mb-3">';

                    if($familyHead->photo)
                    {
                        $html .= '
                            <img src="'.asset('storage/'.$familyHead->photo).'"
                                style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #ddd;">
                        ';
                    }
                    else
                    {
                        $html .= '
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                                style="width:120px;height:120px;border-radius:50%;">
                        ';
                    }

        $html .= '
                </div>

                <div class="col-md-4 mt-2">
                    <strong>Full Name :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.$familyHead->full_name.'
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Birthdate :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.Carbon::parse($familyHead->birthdate)->format('d-m-Y').'
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Mobile No :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.$familyHead->mobile_no.'
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Address :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.$familyHead->address.'
                </div>
                <div class="col-md-4 mt-2">
                    <strong>State :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.$familyHead->state.'
                </div>
                <div class="col-md-4 mt-2">
                    <strong>City :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.$familyHead->city.'
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Pincode :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.$familyHead->pincode.'
                </div>
                <div class="col-md-4 mt-2">
                    <strong>Marital Status :</strong>
                </div>
                <div class="col-md-8 mt-2">
                    '.ucfirst($familyHead->marital_status).'
                </div>
        ';

        if($familyHead->marital_status == 'married')
        {
            $html .= '
                <div class="col-md-4 mt-2">
                    <strong>Wedding Date :</strong>
                </div>
                <div class="col-md-8 mt-2">
                     '.($familyHead->wedding_date? $familyHead->wedding_date->format('d-m-Y'): '-').'
                </div>
            ';
        }


        $html .= '

            <div class="col-md-12 mt-4">
                <h5>Hobbies</h5>
        ';

        if($familyHead->hobbies->count())
        {
            $html .= '<ul>';

            foreach($familyHead->hobbies as $hobby)
            {
                $html .= '<li>'.$hobby->hobby.'</li>';
            }

            $html .= '</ul>';
        }
        else
        {
            $html .= '<p>No hobbies found</p>';
        }

        $html .= '</div>';


        $html .= '

            <div class="col-md-12 mt-4">
                <h5>Family Members</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Birthdate</th>
                                <th>Marital Status</th>
                                <th>Wedding Date</th>
                                <th>Education</th>
                            </tr>
                        </thead>
                        <tbody>
        ';

        if($familyHead->familyMembers->count())
        {
            foreach($familyHead->familyMembers as $member)
            {
                $html .= '
                    <tr>
                        <td>
                            ';
                            if($member->photo)
                            {
                                $html .= '
                                    <img src="'.asset('storage/'.$member->photo).'"
                                        width="50"
                                        height="50"
                                        style="border-radius:50%;object-fit:cover;">
                                ';
                            }
                            else
                            {
                                $html .= '-';
                            }

                            $html .= '
                        </td>
                        <td>'.$member->name.'</td>
                        <td>'.Carbon::parse($member->birthdate)->format('d-m-Y').'</td>
                        <td>'.ucfirst($member->marital_status).'</td>
                        <td>
                            ';

                            if($member->marital_status == 'married' && $member->wedding_date)
                            {
                                $html .= Carbon::parse($member->wedding_date)->format('d-m-Y');
                            }
                            else
                            {
                                $html .= '-';
                            }

                            $html .= '
                        </td>
                        <td>'.$member->education.'</td>
                    </tr>
                ';
            }
        }
        else
        {
            $html .= '
                <tr>
                    <td colspan="6" class="text-center">
                        No family members found
                    </td>
                </tr>
            ';
        }

        $html .= '

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        ';

        return [
            'result' => 1,
            'html' => $html,
        ];
    }


    public function getCities(Request $request)
    {
        $stateId = $request->state;
        $cities = config('locations.cities');
        $stateCities = $cities[$stateId] ?? [];
        return response()->json($stateCities);
    }

     private function getStates(): array
    {
         return Config::get('locations.states');
    }



    /**
     * Get cities by state (AJAX endpoint)
     */
    // public function getCities(Request $request)
    // {
    //     $state = $request->get('state');
    //     $cities = $this->getCitiesByState($state);
    //     return response()->json($cities);
    // }

    /**
     * Returns states list.
     */

    /**
     * Returns cities by state.
     */
    // private function getCitiesByState(string $state): array
    // {
    //     return Config::get("locations.cities.$state", ['Other']);
    // }
}
