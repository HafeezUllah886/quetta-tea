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
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control">
                                </div>

                            <div class="form-group mt-2">
                                <label for="catID">Category</label>
                                <select name="catID" id="catID" class="form-control">
                                 @foreach ($cats as $cat)
                                     <option value="{{$cat->id}}">{{$cat->name}}</option>
                                 @endforeach
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label for="kitchenID">Kitchen</label>
                               <select name="kitchenID" id="kitchenID" class="form-control">
                                @foreach ($kitchens as $kit)
                                    <option value="{{$kit->id}}">{{$kit->name}}</option>
                                @endforeach
                               </select>
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


@section('page-js')
    <script>
        $(".customer").hide();
        $("#type").on("change",  function (){
            var type = $("#type").find(":selected").val();

            if(type === "Business")
            {
                $("#catBox").show();
            }
            else
            {
                $("#catBox").hide();
            }

            if(type === "Customer")
            {
                $(".customer").show();
            }
            else
            {
                $(".customer").hide();
            }
        });
    </script>
@endsection
