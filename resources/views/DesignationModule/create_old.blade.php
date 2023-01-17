@extends('layouts.panel')

@section('content')
    <style>
        button .list-group-item :hover {
            /* background-color: red;  */
        }

    </style>
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header card" id="grv_margin">
            <div class="row first_row_margin">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class=" fas fa-university mr-2"></i>
                        <div class="d-inline">
                            <h5>Add Role Excess</h5>
                            <p class="heading_Bottom">Add New Designation Module</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="../home"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="../home">Dashboard Analytics</a> </li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="container">
                                             <div class="row">
                                              <div class="col-md-6">
                                                <h3>Add Bank</h3>
                                                <p class="heading_Bottom"><i class="fas fa-university mr-2"></i> Add New Bank</p>
                                                </div>
                                            </div> -->
                <div class="container-fluid bg-white mt-2 mb-3 border_radius box">
                    <div class="row">
                        <div class="col-md-12 mt-3 mb-3">
                            <form action="{{ route('DesignationModule.store') }}" method="POST">
                                @csrf
                                <div class="container-fluid">
                                    <div class="row first_row_margin">
                                        <div class="col-md-6">
                                            <h2 class="form-control-sm form_style yash_heading"><i
                                                    class="fas fa-university mr-2"></i><b>Designation Module Information</b>
                                            </h2>
                                        </div>
                                        <div class="col-md-6" style="text-align:right;">
                                            <a class="btn btn-link btn-primary" data-toggle="collapse"
                                                data-target="#collapseExample" aria-expanded="true"
                                                aria-controls="collapseExample" style="margin-top: 10px;">
                                                <i class="fa" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <hr class="border-dark bold">
                                    <div class="form-row mt-3 mb-3 collapse show" id="collapseExample">

                                        <div class="col-md-3 mb-3 ">
                                            <label class="yash_star" style="margin-bottom:0px;"> Select Designation
                                            </label>

                                            <select name="designation_id" class="chosen-select" required
                                                onchange="getModulePrevAccess(this.value)">
                                                <option value="">Select</option>
                                                @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}">{{ $designation->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row" id="modulecontainer" style="display: none">
                                        <div class="col-md-12">
                                            <table class="table table-bordered ">
                                                <tr>
                                                    <th>Parent Module</th>
                                                    <th>Child Module</th>

                                                </tr>
                                                <tr>
                                                    <td class="list-group ">
                                                        @foreach ($all_modules as $module)
                                                            <a class="list-group-item ist-group-item-action table-hover my-1"
                                                                type="button">
                                                                <input class="mr-2 modules" type="checkbox"
                                                                    name="module_id[]"
                                                                    onclick="getChildModules({{ $module->id }} , this)"
                                                                    value="{{ $module->id }}">
                                                                {{ $module->module_name }}

                                                            </a>
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="col-md-8 ">
                                                        <table class="table my-1" id="childModulesContainer">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name <input type="checkbox"
                                                                            onclick="checkAll(this)" /></th>
                                                                    <th>Add</th>
                                                                    <th>Edit</th>
                                                                    <th>Delete</th>
                                                                    <th>upload </th>
                                                                    <th>Download</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </td>
                                                </tr>





                                            </table>
                                        </div>





                                    </div>

                                </div>

                                <div class="col-md-12" style="text-align: right;">
                                    <hr class="mt-3 border-dark bold">

                                    <button class="blob-btn" id="cancelbtn" action="action"
                                        onclick="window.history.go(-1); return false;" type="submit"><i
                                            class="fas fa-times pr-2"></i>
                                        Cancel
                                        <span class="blob-btn__inner">
                                            <span class="blob-btn__blobs">
                                                <span class="blob-btn__blob"></span>
                                                <span class="blob-btn__blob"></span>
                                                <span class="blob-btn__blob"></span>
                                                <span class="blob-btn__blob"></span>
                                            </span>
                                        </span>
                                    </button>
                                    <button id="submitbtn" type="submit" class="blob-btn1"><i
                                            class="fas fa-check pr-2"></i>
                                        Save Changes
                                        <span class="blob-btn__inner1">
                                            <span class="blob-btn__blobs1">
                                                <span class="blob-btn__blob1"></span>
                                                <span class="blob-btn__blob1"></span>
                                                <span class="blob-btn__blob1"></span>
                                                <span class="blob-btn__blob1"></span>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- Close Row -->
            </div>
            <!-- Close Container -->
        </div>

        <script>
            function getModulePrevAccess(designation_id) {
                // console.log(designation_id);
                document.getElementById("modulecontainer").style.display = "block";
                let modules = document.querySelectorAll(".modules");
                modules.forEach(eachmodule => {
                    eachmodule.checked = false;
                });
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "get",
                    url: app_url + 'get_module_prev_access',
                    dataType: 'json',
                    data: {
                        'designation_id': designation_id
                    },
                    success: function(data) {

                        let moduledata = data.response;

                        if (moduledata != '') {

                            modules.forEach(eachmodule => {

                                moduledata.forEach(eachdata => {

                                    if (eachdata.module_id == eachmodule.value) {

                                        eachmodule.checked = true;
                                    }


                                })


                            })

                            let childModulesContainer = document.getElementById("childModulesContainer");

                            moduledata.forEach(child_module => {
                                row = ``;
                                newrow = document.createElement("tr");
                                newrow.className="childof"+child_module.modules.parent_id;
                                
                                row +=
                                    ` <td>${child_module.modules.module_name} <input type="text" hidden value="${child_module.id}" name="module_id[]" />  </td>`
                                child_module.add == 1 ? row +=
                                    `<td><input type="checkbox" checked value="1" class="accesscheckbox" name="add[${child_module.id}]" ></td>` :
                                    row +=
                                    ` <td><input type="checkbox" value="1" class="accesscheckbox" name="add[${child_module.id}]" ></td>`;
                                child_module.edit == 1 ? row +=
                                    `<td><input type="checkbox" checked value="1" class="accesscheckbox" name="edit[${child_module.id}]"></td>` :
                                    row +=
                                    `<td><input type="checkbox" value="1" class="accesscheckbox" name="edit[${child_module.id}]"></td>`;
                                child_module.delete == 1 ? row +=
                                    `<td><input type="checkbox" checked value="1" class="accesscheckbox" name="delete[${child_module.id}]" ></td>` :
                                    row +=
                                    `<td><input type="checkbox" value="1" class="accesscheckbox" name="delete[${child_module.id}]" ></td>`;
                                child_module.upload == 1 ? row +=
                                    `<td><input type="checkbox" checked value="1" class="accesscheckbox" name="upload[${child_module.id}]"></td>` :
                                    row +=
                                    `<td><input type="checkbox" value="1" class="accesscheckbox" name="upload[${child_module.id}]"></td>`;
                                child_module.download == 1 ? row +=
                                    `<td><input type="checkbox" checked value="1" class="accesscheckbox" name="download[${child_module.id}]"></td>` :
                                    row +=
                                    `<td><input type="checkbox" value="1" class="accesscheckbox" name="download[${child_module.id}]"></td>`;
                                newrow.innerHTML = row;
                                console.log(row);
                                childModulesContainer.appendChild(newrow);
                            })
                        } else {
                            let childModulesContainer = document.getElementById("childModulesContainer");
                            // let row=document.createElement('tr');
                            // row.innerHTML='';
                            // childModulesContainer.appendChild(row);
                            childModulesContainer.innerHTML = `   <tr>
                                                                    <th>Name <input type="checkbox"
                                                                            onclick="checkAll(this)" /></th>
                                                                    <th>Add</th>
                                                                    <th>Edit</th>
                                                                    <th>Delete</th>
                                                                    <th>upload </th>
                                                                    <th>Download</th>
                                                                </tr>`;
                        }

                    }
                })






            }



            function getChildModules(parent_module_id, element) {

                if (element.checked == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "get",
                        url: app_url + 'get_child_modules',
                        dataType: 'json',
                        data: {
                            'parent_module_id': parent_module_id
                        },
                        success: function(data) {
                            //  console.log(data);
                            let child_modules = data.response;
                            let childModulesContainer = document.getElementById("childModulesContainer");

                            child_modules.forEach(child_module => {
                                //  console.log(child_module.module_name);
                                newrow = document.createElement("tr");
                                newrow.className="childof"+parent_module_id;
                                newrow.innerHTML = `
                                   <td>${child_module.module_name} <input type="text" hidden value="${child_module.id}" name="module_id[]" />  </td>
                                   <td><input type="checkbox" value="1" class="accesscheckbox" name="add[${child_module.id}]" ></td>
                                   <td><input type="checkbox" value="1" class="accesscheckbox" name="edit[${child_module.id}]"></td>
                                   <td><input type="checkbox" value="1" class="accesscheckbox" name="delete[${child_module.id}]" ></td>
                                   <td><input type="checkbox" value="1" class="accesscheckbox" name="upload[${child_module.id}]"></td>
                                   <td><input type="checkbox" value="1" class="accesscheckbox" name="download[${child_module.id}]"></td>
                                `;
                                childModulesContainer.appendChild(newrow)
                            })


                        }
                    })

                }
                else{
                    console.log("else part working")
                    classname= "childof"+parent_module_id;
                    console.log(classname);
                    let eachparentchild= document.querySelectorAll(`.${classname}
                    
                    `);
                    eachparentchild.forEach(each=>{
                        console.log(each);
                        each.style.display="none";
                    })
                }
            }

            function checkAll(elem) {
                // console.log(elem)
                let all_checkbox = document.querySelectorAll(".accesscheckbox");


                all_checkbox.forEach(each => {
                    if (elem.checked) {
                        each.checked = true;

                    } else {
                        each.checked = false;

                    };
                })
            }
        </script>
    @endsection
