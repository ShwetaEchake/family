<x-admin.layout>
    <x-slot name="title">  Registration</x-slot>
    <x-slot name="heading"> Registration</x-slot>


        <!-- Add Form -->
        <div class="row" id="addContainer" style="">
            <div class="col-sm-12">
                <div class="card">
                    <form class="theme-form" name="addForm" id="addForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Family Head — Basic Information</h4>
                            <a href="{{ route('family.index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    <label class="col-form-label" for="name"> Name <span class="text-danger">*</span></label>
                                    <input class="form-control" id="name" name="name" type="text" placeholder="Enter First name">
                                    <span class="text-danger is-invalid name_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="surname">Surname <span class="text-danger">*</span></label>
                                    <input class="form-control" id="surname" name="surname" type="text" placeholder="Enter surname">
                                    <span class="text-danger is-invalid surname_err"></span>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label" for="birthdate">Birthdate <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}"
                                        max="{{ now()->subYears(21)->toDateString() }}">
                                    <span class="text-danger is-invalid birthdate_err"></span>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-4 mb-3">
                                    <label>Mobile No <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_no" class="form-control"  placeholder="10-digit mobile number" maxlength="10">
                                    <span class="text-danger mobile_no_err"></span>
                                </div>
                                 <div class="col-md-4 mb-3">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="address" class="form-control" placeholder="Enter address"></textarea>
                                    <span class="text-danger is-invalid address_err"></span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Photo <span class="text-danger">*</span></label>
                                    <input type="file" name="photo" class="form-control">
                                    <span class="text-danger  photo_err"></span>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                 <div class="col-md-4 mb-3">
                                    <label>State <span class="text-danger">*</span></label>
                                    <select name="state" id="state" class="form-control">
                                        <option value="">Select State</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Gujarat">Gujarat</option>
                                    </select>
                                    <span class="text-danger state_err"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>City <span class="text-danger">*</span></label>
                                    <select name="city" id="city" class="form-control">
                                        <option value="">Select City</option>
                                    </select>
                                    <span class="text-danger city_err"></span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label>Pincode <span class="text-danger">*</span></label>
                                    <input type="text" name="pincode" class="form-control" placeholder="Enter pincode">
                                    <span class="text-danger pincode_err"></span>
                                </div>
                            </div>

                            <div class="row">

                                {{-- Marital Status --}}
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label>Marital Status <span class="text-danger">*</span></label>
                                        <div class="radio-group">
                                            <label class="radio-label">
                                                <input type="radio" name="marital_status" value="married"
                                                    {{ old('marital_status') === 'married' ? 'checked' : '' }}> Married
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="marital_status" value="unmarried"
                                                    {{ old('marital_status') === 'unmarried' ? 'checked' : '' }}> Unmarried
                                                </label>
                                            </div>
                                            <span class="text-danger marital_status_err"></span>
                                    </div>
                                </div>

                                {{-- Wedding Date --}}
                                <div class="col-md-4 mb-3" id="wedding-date-wrap"  style="display:none;">
                                    <div class="form-group">
                                        <label> Wedding Date <span class="req">*</span> </label>
                                        <input type="date"
                                            name="wedding_date"
                                            id="wedding_date"
                                            value="{{ old('wedding_date') }}"
                                            max="{{ now()->toDateString() }}"
                                            class="form-control">

                                        <span class="text-danger wedding_date_err"></span>
                                    </div>
                                </div>
                            </div>



                            {{-- HOBBIES --}}
                            <div class="form-section">

                                <div class="form-section-header">
                                    <label> Hobbies <span class="text-danger">*</span></label>
                                </div>

                                <div class="form-section-body">
                                    <div id="hobby-list" class="row">
                                        @if(old('hobbies'))
                                            @foreach(old('hobbies') as $hobby)
                                                <div class="col-md-4 mb-3 hobby-item">
                                                    <div class="input-group">

                                                        <input type="text"
                                                            class="form-control"
                                                            name="hobbies[]"
                                                            value="{{ $hobby }}"
                                                            placeholder="Enter a hobby">

                                                        <button type="button"
                                                            class="btn btn-danger"
                                                            onclick="removeHobby(this)">
                                                            ✕
                                                        </button>

                                                    </div>
                                                    <span class="text-danger hobbies_err"></span>

                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-md-4 mb-3 hobby-item">
                                                <div class="input-group">
                                                    <input type="text"
                                                        name="hobbies[]"
                                                        class="form-control"
                                                        placeholder="e.g. Reading, Gardening, Cricket">

                                                    <button type="button"
                                                        class="btn btn-danger"
                                                        onclick="removeHobby(this)">
                                                        ✕
                                                    </button>
                                                </div>
                                                <span class="text-danger hobbies_err"></span>

                                            </div>
                                        @endif
                                    </div>


                                    <button type="button"
                                        class="btn btn-outline-primary btn-sm mt-2"
                                        onclick="addHobby()">
                                        ➕ Add Another Hobby
                                    </button>

                                </div>
                            </div><br><br>


                            {{-- FAMILY MEMBERS --}}
                            <div class="card">
                                <div class="card-header bg-primary py-3">
                                    <h4 class="card-title mb-0 fw-bold text-white">
                                        FAMILY MEMBERS
                                    </h4>
                                </div>
                            </div>
                            <div class="panel panel-footer">
                                <table class="table table-bordered" id="dynamicAddRemove">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Birthdate</th>
                                            <th>Marital Status</th>
                                            <th>Wedding Date</th>
                                            <th>Education</th>
                                            <th>Photo</th>
                                            <th>
                                                <button type="button" class="btn btn-sm btn-success addMoreForm">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody id="addMore">
                                        <tr id="row_0">
                                            <td>
                                                <input type="text" name="member_name[]"  class="form-control">
                                                <span class="text-danger member_name_err"></span>
                                            </td>
                                            <td>
                                                <input type="date" name="member_birthdate[]"   class="form-control">
                                                <span class="text-danger member_birthdate_err"></span>
                                            </td>
                                            <td nowrap>
                                                <label>
                                                    <input type="radio"
                                                        name="member_marital_status[]"
                                                        value="married"
                                                        onchange="toggleWeddingDate(0, this.value)">
                                                    Married
                                                </label>
                                                <label class="ms-2">
                                                    <input type="radio"
                                                        name="member_marital_status[]"
                                                        value="unmarried" checked
                                                        onchange="toggleWeddingDate(0, this.value)">
                                                    Unmarried
                                                </label>
                                            </td>
                                            <td>
                                                <input type="date"
                                                    name="member_wedding_date[]"
                                                    id="wedding_date_0"
                                                    max="{{ now()->toDateString() }}"
                                                    class="form-control"
                                                    style="display:none;">
                                                    <span class="text-danger member_wedding_date_err"></span>
                                            </td>
                                            <td>
                                                <input type="text" name="education[]"  class="form-control">
                                                <span class="text-danger education_err"></span>
                                            </td>
                                            <td>
                                                <input type="file" name="document[]"  class="form-control">
                                                <span class="text-danger document_err"></span>
                                            </td>
                                            <td>
                                                <button type="button"
                                                        class="btn btn-sm btn-danger removeAddMore">
                                                    <i class="fa fa-remove"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="addSubmit">Submit</button>
                            <button type="reset" class="btn btn-warning">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>





</x-admin.layout>



<script>
   function showError(message) {
        swal("Validation Error", message, "error");
   }

    function validateForm() {

        let name = $('#name').val().trim();
        if (!name) {
            showError('Name is required');
            return false;
        }

        let surname = $('#surname').val().trim();
        if (!surname) {
            showError('Surname is required');
            return false;
        }

        let birthdate = $('#birthdate').val();
        if (!birthdate) {
            showError('Birthdate is required');
            return false;
        }

        let mobile = $('[name="mobile_no"]').val();
        if (!mobile || !/^[6-9]\d{9}$/.test(mobile)) {
            showError('Enter valid mobile number');
            return false;
        }

        let address = $('[name="address"]').val();
        if (!address) {
            showError('Address is required');
            return false;
        }

        let photo = $('[name="photo"]')[0].files[0];
        if (!photo) {
            showError('Photo is required');
            return false;
        }

        if (!$('#state').val()) {
            showError('State is required');
            return false;
        }

        if (!$('#city').val()) {
            showError('City is required');
            return false;
        }

        let pin = $('[name="pincode"]').val();
        if (!pin || !/^\d{6}$/.test(pin)) {
            showError('Valid 6-digit pincode required');
            return false;
        }

        let marital = $('input[name="marital_status"]:checked').val();
        if (!marital) {
            showError('Select marital status');
            return false;
        }

        if (marital === 'married' && !$('#wedding_date').val()) {
            showError('Wedding date is required');
            return false;
        }

        let hobbyFilled = false;
        $('[name="hobbies[]"]').each(function () {
            if ($(this).val().trim() !== '') {
                hobbyFilled = true;
            }
        });

        if (!hobbyFilled) {
            showError('At least one hobby required');
            return false;
        }



        // FAMILY MEMBERS (ONLY FIRST ERROR SHOW)
        // let valid = true;
        // $('#addMore tr').each(function (index, row) {

        //     let name = $(row).find('[name="member_name[]"]').val();
        //     let birth = $(row).find('[name="member_birthdate[]"]').val();

        //     let marital = $(row).find('input[type="radio"]:checked').val();

        //     if (name && name.trim() !== '') {

        //         if (!birth) {
        //             showError(`Row ${index + 1}: Birthdate required`);
        //             valid = false;
        //             return false;
        //         }

        //         if (!marital) {
        //             showError(`Row ${index + 1}: Marital status required`);
        //             valid = false;
        //             return false;
        //         }

        //         if (marital === 'married') {

        //             let wedding = $(row).find('input[name*="wedding_date"]').val();

        //             if (!wedding) {
        //                 showError(`Row ${index + 1}: Wedding date required`);
        //                 valid = false;
        //                 return false;
        //             }
        //         }
        //     }
        // });
        // return valid;







        return true;

    }
</script>




{{-- Add --}}
<script>
    $("#addForm").submit(function(e) {
        e.preventDefault();

            if (!validateForm()) {
                return;
            }

        $("#addSubmit").prop('disabled', true);

        var formdata = new FormData(this);
        $.ajax({
            url: '{{ route('family.store') }}',
            type: 'POST',
            data: formdata,
            contentType: false,
            processData: false,
            success: function(data)
            {
                $("#addSubmit").prop('disabled', false);
                if (!data.error2)
                    swal("Successful!", data.success, "success")
                        .then((action) => {
                            window.location.href = '{{ route('family.index') }}';
                        });
                else
                    swal("Error!", data.error2, "error");
            },
            statusCode: {
                422: function(responseObject, textStatus, jqXHR) {
                    $("#addSubmit").prop('disabled', false);
                    resetErrors();
                    printErrMsg(responseObject.responseJSON.errors);
                },
                500: function(responseObject, textStatus, errorThrown) {
                    $("#addSubmit").prop('disabled', false);
                    swal("Error occured!", "Something went wrong please try again", "error");
                }
            }
        });

    });
</script>



<script>
// ═══════════════════════════ MARITAL STATUS ═══════════════════════════
document.querySelectorAll('input[name="marital_status"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const wrap = document.getElementById('wedding-date-wrap');
        const weddingInput = document.getElementById('wedding_date');
        if (this.value === 'married') {
            wrap.style.display = 'block';
            weddingInput.required = true;
        } else {
            wrap.style.display = 'none';
            weddingInput.required = false;
            weddingInput.value = '';
            clearError('wedding_date');
        }
    });
    if (radio.checked) radio.dispatchEvent(new Event('change'));
});

function toggleMemberWedding(idx, status) {
    const wrap = document.getElementById(`member-wedding-${idx}`);
    const input = wrap ? wrap.querySelector('input') : null;
    if (!wrap) return;
    if (status === 'married') {
        wrap.style.display = 'block';
        if (input) input.required = true;
    } else {
        wrap.style.display = 'none';
        if (input) { input.required = false; input.value = ''; }
    }
}
</script>


<script>
// ═══════════════════════════ HOBBIES ═══════════════════════════
function addHobby()
{
    const list = document.getElementById('hobby-list');
    const div = document.createElement('div');
    div.className = 'col-md-4 mb-3 hobby-item';
    div.innerHTML = `
        <div class="input-group">

            <input type="text"
                class="form-control"
                name="hobbies[]"
                placeholder="Enter a hobby">

            <button type="button"
                class="btn btn-danger"
                onclick="removeHobby(this)">
                ✕
            </button>

        </div>
    `;

    list.appendChild(div);
    div.querySelector('input').focus();
}

function removeHobby(btn)
{
    const list = document.getElementById('hobby-list');

    if (list.children.length > 1)
    {
        btn.closest('.hobby-item').remove();
    }
    else
    {
        btn.closest('.hobby-item').querySelector('input').value = '';
    }
}
</script>



 {{-- Add More Form --}}
<script>

    $('.addMoreForm').on('click',function(){
        addMoreForm();
    });

    var rowId = 1;
    function addMoreForm() {
            var tr =
            '<tr id="row_' + rowId + '">' +
                '<td><input type="text" name="member_name[]" class="form-control" ><span class="text-danger member_name_err"></span></td>' +
                '<td><input type="date" name="member_birthdate[]" class="form-control" ><span class="text-danger member_birthdate_err"></span></td>' +
                '<td><input type="radio" name="member_marital_status[' + rowId + ']" value="married" onchange="toggleWeddingDate(' + rowId + ', this.value)" class="" > Married <input type="radio" name="member_marital_status[' + rowId + ']" value="unmarried"  checked onchange="toggleWeddingDate(' + rowId + ', this.value)" class="" > Unmarried <span class="text-danger member_marital_status_err"></span></td>' +
                '<td><input type="date" name="member_wedding_date[' + rowId + ']"  id="wedding_date_' + rowId + '"  style="display:none;"  class="form-control" ></td>' +
                '<td><input type="text" name="education[]" class="form-control" ><span class="text-danger education_err"></span></td>' +
                '<td><input type="file" name="document[]" class="form-control" ><span class="text-danger document_err"></span></td>' +
                '<td><a href="javascrip:" class="btn btn-sm btn-danger removeAddMore" data-rowid="' + rowId + '"><i class="fa fa-remove"></i></a></td>' +
            '</tr>';

            $('#addMore').append(tr);
            rowId++;
    }



// REMOVE ROW
$(document).on('click', '.removeAddMore', function () {

    if ($('#addMore tr').length > 1)
    {
        $(this).closest('tr').remove();
    }
    else
    {
        alert('At least one row required');
    }

});


// SHOW/HIDE WEDDING DATE
function toggleWeddingDate(rowId, value)
{
    let input = $('#wedding_date_' + rowId);

    if(value == 'married')
    {
        input.show();
    }
    else
    {
        input.hide();
        input.val('');
    }
}
</script>



{{-- State City Dropdown --}}
<script>
    $('#state').change(function () {

        let state = $(this).val();

        $('#city').html('<option value="">Loading...</option>');

        $.ajax({
            url: "{{ route('ajax.cities') }}",
            type: "GET",
            data: { state : state },

            success: function(response)
            {
                $('#city').html('<option value="">Select City</option>');

                $.each(response, function(key, value) {
                    $('#city').append(
                        `<option value="${value}">${value}</option>`
                    );
                });
            }
        });

    });
</script>





