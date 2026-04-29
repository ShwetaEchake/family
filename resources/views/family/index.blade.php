<x-admin.layout>
    <x-slot name="title">family</x-slot>
    <x-slot name="heading">family</x-slot>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="">
                                    <a href="{{ route('family.create') }}" class="btn btn-primary">
                                        Add <i class="fa fa-plus"></i>
                                    </a>
                                    <button id="btnCancel" class="btn btn-danger" style="display:none;">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="buttons-datatables" class="table table-bordered nowrap align-middle" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>State / City</th>
                                        <th>Marital Status</th>
                                        <th style="text-align:center">Members</th>
                                        <th>Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($familyHeads as $head)
                                        <tr>
                                            <td style="">{{ $loop->iteration }}</td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:0.7rem">
                                                    @if($head->photo)
                                                        <img src="{{ Storage::url($head->photo) }}" alt="" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid var(--gold)">
                                                    @else
                                                        <div style="width:36px;height:36px;border-radius:50%;background:var(--warm);display:flex;align-items:center;justify-content:center;font-size:1rem">👤</div>
                                                    @endif
                                                    <div>
                                                        <div style="font-weight:600">{{ $head->full_name }}</div>
                                                        <div style="font-size:0.78rem;color:var(--gray)">{{ $head->birthdate->format('d M Y') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $head->mobile_no }}</td>
                                            <td>
                                                <div style="font-size:0.8rem;color:var(--gray)">{{ $head->state }}</div>
                                                <div>{{ $head->city }}</div>
                                            </td>
                                            <td>
                                                @if($head->marital_status === 'married')
                                                    Married
                                                @else
                                                    Unmarried
                                                @endif
                                            </td>
                                            <td style="text-align:center">
                                                <button class="family-info btn btn-primary px-2 py-1" title="More info" data-id="{{ $head->id }}">{{ $head->family_members_count }}</button>
                                            </td>
                                            <td style="font-size:0.82rem;color:var(--gray)">{{ $head->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" style="text-align:center;padding:3rem;color:var(--gray)">
                                                <div style="font-size:2.5rem;margin-bottom:0.5rem">🏡</div>
                                                <div style="font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:0.3rem">No families registered yet</div>
                                            </td>
                                        </tr>
                                        @endforelse

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


          {{-- Show More Info Modal --}}
            <div class="modal fade" id="more-info-modal" role="dialog" >
                <div class="modal-dialog modal-xl" role="document">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Family  Info</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="familyMoreInfo">

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                </div>
            </div>




</x-admin.layout>

<!-- Show Details -->
<script>
    $("#buttons-datatables").on("click", ".family-info", function(e) {
        e.preventDefault();
        var model_id = $(this).attr("data-id");
        var url = "{{ route('family.show', ':model_id') }}";

        $.ajax({
            url: url.replace(':model_id', model_id),
            type: 'GET',
            data: {
                '_token': "{{ csrf_token() }}"
            },
            success: function(data, textStatus, jqXHR)
            {
                if (data.result == 1)
                {
                    $("#more-info-modal").modal('show');
                    $("#familyMoreInfo").html(data.html);
                }
                else
                {
                    swal("Error!", "Some thing went wrong", "error");
                }
            },
            error: function(error, jqXHR, textStatus, errorThrown) {
                swal("Error!", "Some thing went wrong", "error");
            },
        });
    });
</script>











