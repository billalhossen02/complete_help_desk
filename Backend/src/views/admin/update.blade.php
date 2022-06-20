@extends('layouts.app')

@section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
       <div class="row">
          <div class="col-sm-12">
             <div class="iq-card">
                <div class="iq-card-body">
                    <div class="">
                        <div class='row'>
                        <div class="col-md-6">
                            <h3 class="header">TICKET NO #{{$data->id}}</h3>
                            <hr>
                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="name">Name</label>
                              <p>{{$data->user_name}}</p>
                            </div>
                            <div class="form-group col-md-6">
                              <label for="email">Email</label>
                              <p>{{$data->user_email}}</p>
                            </div>
                          </div>

                          @if($data->subject)
                          <div class="form-row">
                              <div class="form-group col-md-6">
                                <label for="subject">Subject</label>
                                <p>{{$data->subject}}</p>
                              </div>

                          @else

                          <div class="form-row">
                            <div class="form-group col-md-6">
                              <label for="subject">Subject</label>
                              <p>No Subject</p>
                            </div>

                          @endif
                          
                              <div class="form-group col-md-6">
                                <label for="subject">Support</label><br>
                                  <p>{{$data->department}}</p>
                                </div>
                              </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="subject">Priority</label><br>
                                    <p>{{$data->priority}}</p>
                                </div>
                  
                                <div class="form-group col-md-6">
                                  <label for="message">Message</label><br>
                                    <p>{{$data->message}}</p>
                                </div>

                              @if($data->attachment != 'NULL')
                                <div class="form-group">
                                 <a href="{{ domain('').$data->attachment }}"><img src="{{ domain('').$data->attachment }}" style="width:200px; margin-right:160px"></a>
                                </div>
                              @else
                                <div class="form-group">
                                  <p>No Attachment</p>
                                </div>
                              </div>  
                              @endif
                            <form action="{{route('admin.support.update')}}?id={{ $data->id }}" method="POST" enctype="multipart/form-data">
                            @csrf   
                          <div class="form-group">
                            <label >Status</label>
                            <select name='status' class="">
                              <option value="Open">Open</option>
                              <option value="Closed">Closed</option>
                              <option value="Answered">Answered</option>
                            </select>
                          </div><br><br>

                          
                          <div>
                          <a href="{{route('admin.support.template')}}"><button type="button" class="btn btn-danger">Back</button></a>
                          <button type="submit" class="btn btn-success">Update</button>
                        </div>
                        </form> 
                      </div>  
                     </div>
                    </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
</div>
 
@endsection

