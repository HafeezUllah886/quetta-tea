@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Create Menu Item</h3>
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
                    <form action="{{ route('account.store') }}" method="post">
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
                            </div>
                            <div class="col-6">
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="justify-content-between d-flex align-items-center mb-3">
                                            <h5 class="mb-0">Item Image</h5>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <input type="file" class="filepond filepond-input-multiple"
                                                    name="filepond" data-allow-reorder="true" data-max-file-size="3MB"
                                                    data-max-files="3">
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->

                                        <!-- end row -->
                                    </div>
                                    <!-- end col -->
                                </div>
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
    <link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}" type="text/css" />
@endsection
@section('page-js')
    <script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/form-file-upload.init.js') }}"></script>
    <script>
        var optionCount = 1;
        function addOption() {
            optionCount += 1;
            var html = '<tr id="row_' + optionCount + '">';
            html += '<td><input type="text" name="title[]" class="form-control form-control-sm" id="title_' + optionCount + '"></td>';
            html += '<td><input type="number" name="price[]" class="form-control form-control-sm" id="price_' + optionCount + '"></td>';
            html += '<td><input type="number" name="dprice[]" class="form-control form-control-sm" id="dprice_' + optionCount + '"></td>';
            html += '<td> <span class="btn btn-sm btn-danger" onclick="deleteRow(' + optionCount + ')">X</span>' + optionCount + ' </td>';
            html += '</tr>';
            $("#options").append(html);
        }
        function deleteRow(optionCount) {
            $('#row_' + optionCount).remove();
        }
    </script>
@endsection
