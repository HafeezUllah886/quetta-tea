@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Create Menu Item</h3>
                    <a href="{{route('items.index')}}" class="btn btn-primary ">View List</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('items.store') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label for="catID">Category</label>
                                    <select name="catID" id="catID" class="form-control">
                                        @foreach ($cats as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="kitchenID">Kitchen</label>
                                    <select name="kitchenID" id="kitchenID" class="form-control">
                                        @foreach ($kitchens as $kit)
                                            <option value="{{ $kit->id }}">{{ $kit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="img">Image</label>
                                    <input type="file" id="img" class="form-control mb-3" name="img">
                                    <img id="imgPreview" src="#" alt="Image Preview" style="display: none; width: 100px; height: 100px;border-radius:20px;">
                                </div>
                            </div>
                            <div class="col-6 p-0">
                                <div class="card-header d-flex justify-content-between">
                                    <h5>Options</h5>
                                    <button type="button" class="btn btn-sm btn-success" onclick="addOption()">+</button>
                                </div>
                                <table class="w-100">
                                    <thead>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>Discounted Price</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="options">
                                        <tr>
                                            <td>
                                                <input type="text" name="title[]" required id="title_1"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="number" name="price[]" required id="price_1"
                                                    class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="number" name="dprice[]" required id="dprice_1"
                                                    class="form-control form-control-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="card-header d-flex justify-content-between">
                                    <h5>Deal Beverages</h5>
                                </div>
                                <div class="row">
                                    <div class="col-10 ">
                                        <select class="selectize" id="raw">
                                           @foreach ($materials as $raw)
                                               <option value="{{$raw->id}}" data-name="{{$raw->name}}">{{$raw->name}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button class="w-100 btn btn-success" type="button" onclick="addRaw()">+</button>
                                    </div>
                                </div>
                                <table  class="w-100 table">
                                    <thead>
                                        <th>Item Name</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="raws">

                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="col-12 mt-3">
                            <button type="submit" class="btn btn-secondary w-100">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Default Modals -->
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.min.css') }}">
@endsection

@section('page-js')
<script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
    <script>
          $(".selectize").selectize();
        var optionCount = 1;
        function addOption() {
            optionCount += 1;
            var html = '<tr id="row_' + optionCount + '">';
            html += '<td><input type="text" name="title[]" class="form-control form-control-sm" id="title_' + optionCount + '"></td>';
            html += '<td><input type="number" name="price[]" class="form-control form-control-sm" id="price_' + optionCount + '"></td>';
            html += '<td><input type="number" name="dprice[]" class="form-control form-control-sm" id="dprice_' + optionCount + '"></td>';
            html += '<td> <span class="btn btn-sm btn-danger" onclick="deleteRow(' + optionCount + ')">X</span></td>';
            html += '</tr>';
            $("#options").append(html);
        }
        function deleteRow(optionCount) {
            $('#row_' + optionCount).remove();
        }
        function addRaw() {
            var selectizeInstance = $("#raw")[0].selectize; // Access the Selectize instance
            var raw_id = selectizeInstance.getValue(); // Get the selected value (from the 'value' attribute)
            var raw_name = selectizeInstance.options[raw_id]?.name; // Access the data-name equivalent

            var html = '<tr class="p-0" id="rowRaw_' + raw_id + '">';
            html += '<td width="90%" class="p-0">'+raw_name+'</td>';
            html += '<td class="p-0"> <span class="btn btn-sm btn-danger" onclick="deleteRowRaw(' + raw_id + ')">X</span></td>';
            html += '<input type="hidden" name="rawID[]" value="'+raw_id+'">';
            html += '</tr>';

            $("#raws").append(html);
        }
        function deleteRowRaw(optionCount) {
            $('#rowRaw_' + optionCount).remove();
        }
        $("#img").change(function () {
        // Get the selected file
        var file = this.files[0];
        if (file) {
            // Create a FileReader
            var reader = new FileReader();
            // Set a function to run when the file is loaded
            reader.onload = function (e) {
                // Set the source of the image element to the Data URL
                $("#imgPreview").attr("src", e.target.result);
                // Display the image element
                $("#imgPreview").show();
            };
            // Read the file as a Data URL
            reader.readAsDataURL(file);
        }
    });
    </script>
@endsection
