@extends('layout.app')
@section('content')
<div class="row">
       <div class="col-12">
              <div class="card">
                     <div class="card-header d-flex justify-content-between">
                            <h3>{{$type}}s</h3>
                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#new">Create New</button>
                     </div>
                     @php
                     $types = ['Store Keeper', 'Kitchen'];
                 @endphp
                     <div class="card-body">
                            <table class="table">
                                   <thead>
                                          <th>#</th>
                                          <th>Name</th>
                                          @if (!in_array($type, $types))
                                          <th>Balance</th>
                                          @endif
                                          <th>Action</th>
                                   </thead>
                                   <tbody>
                                          @foreach ($users as $key => $user)
                                                 <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$user->name}}</td>
                                                        @if (!in_array($type, $types))
                                                        <td>{{getUserAccountBalance($user->id)}}</td>
                                                        @endif

                                                        <td>
                                                               <div class="dropdown">
                                                                      <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                                          data-bs-toggle="dropdown" aria-expanded="false">
                                                                          <i class="ri-more-fill align-middle"></i>
                                                                      </button>
                                                                      <ul class="dropdown-menu dropdown-menu-end">
                                                                             @if (!in_array($type, $types))
                                                                          <li>
                                                                              <button class="dropdown-item" href="javascript:void(0);"
                                                                                  onclick="ViewStatment({{ $user->id}})"><i
                                                                                      class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                                                  View Statment
                                                                              </button>
                                                                          </li>
                                                                          @endif
                                                                          
                                                                          <li>
                                                                              <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#edit_{{$user->id}}">
                                                                                  <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                                  Edits
                                                                              </a>
                                                                          </li>
                                                                          
                                                                      </ul>
                                                                  </div>
                                                        </td>
                                                 </tr>
                                                 <div id="edit_{{$user->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myModalLabel">Edit {{$type}}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                                                                </div>
                                                                <form action="{{ route('otherusers.update', $user->id) }}" method="Post">
                                                                  @csrf
                                                                  @method("patch")
                                                                         <div class="modal-body">
                                                                             <div class="form-group">
                                                                                    <label for="name">Name</label>
                                                                                    <input type="text" name="name" value="{{$user->name}}" required id="name" class="form-control">
                                                                             </div>
                                                                             <div class="form-group mt-2">
                                                                                    <label for="password">Password</label>
                                                                                    <input type="password" name="password" id="password" autocomplete="false" class="form-control">
                                                                             </div>
                                                                         </div>
                                                                         <div class="modal-footer">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                         </div>
                                                                  </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                          @endforeach
                                   </tbody>
                            </table>
                     </div>
              </div>
       </div>
</div>
<!-- Default Modals -->

<div id="new" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Create New {{$type}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <form action="{{ route('otherusers.store', [$type]) }}" method="post">
              @csrf
                     <div class="modal-body">
                            <div class="form-group">
                                   <label for="name">Name</label>
                                   <input type="text" name="name" required id="name" class="form-control">
                            </div>
                            <div class="form-group mt-2">
                                   <label for="password">Password</label>
                                   <input type="password" name="password" required id="password" class="form-control">
                            </div>
                            @if (!in_array($type, $types))
                                   <div class="form-group mt-2">
                                          <label for="initial">Initial Balance</label>
                                          <input type="number" name="initial" id="initial" value="0" autocomplete="false" class="form-control">
                                   </div>
                            @endif
                     </div>
                     <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                     </div>
              </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="viewStatmentModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="myModalLabel">View User Account Statment</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
               </div>
               <form method="get" target="" id="form">
                 @csrf
                 <input type="hidden" name="userID" id="userID">
                        <div class="modal-body">
                          <div class="form-group">
                           <label for="">Select Dates</label>
                           <div class="input-group">
                               <span class="input-group-text" id="inputGroup-sizing-default">From</span>
                               <input type="date" id="from" name="from" value="{{ firstDayOfMonth() }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                               <span class="input-group-text" id="inputGroup-sizing-default">To</span>
                               <input type="date" id="to" name="to" value="{{ lastDayOfMonth() }}" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                           </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                               <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                               <button type="button" id="viewBtn" class="btn btn-primary">View</button>
                        </div>
                 </form>
           </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
@endsection

@section('page-js')
<script>
       function ViewStatment(user)
       {
           $("#userID").val(user);
           $("#viewStatmentModal").modal('show');
       }

       $("#viewBtn").on("click", function (){
           var userID = $("#userID").val();
           var from = $("#from").val();
           var to = $("#to").val();
           var url = "{{ route('userStatement', ['id' => ':userID', 'from' => ':from', 'to' => ':to']) }}"
       .replace(':userID', userID)
       .replace(':from', from)
       .replace(':to', to);
           window.open(url, "_blank", "width=1000,height=800");
       });
   </script>
@endsection

