@extends('layouts.app')

@section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
       <div class="row">
          <div class="col-sm-12">
             <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title">Ticket List</h4>
                   </div>
                   <div class="iq-card-header-toolbar d-flex align-items-center">
                      {{-- <a href="{{ route('admin.tag.add') }}" class="btn btn-primary">Add Tag</a> --}}
                   </div>
                </div>
                <div class="iq-card-body">
                   <div class="table-view">
                      <table class="data-tables table movie_table " style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th> 
                                <th>Email</th>
                                <th>Support</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Rating</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                              @foreach ($data as $item)
                                <tr>
                                   
                                    <td>{{$item->user_name }}</td>
                                    <td>{{ $item->user_email }}</td>
                                    <td>{{$item->department}}</td>
                                    @if ($item->status == 'Open') 
                                    <td><span class="badge badge-info">{{$item->status}}</span></td>              
                                    @elseif ($item->status == 'Closed')            
                                     <td><span class="badge badge-primary">{{$item->status}}</span></td>            
                                    @elseif ($item->status == 'Answered' )           
                                      <td><span class="badge badge-warning">{{$item->status}}</span></td>          
                                    @endif
                                    <td>{{$item->updated_at->format("j F, Y : g:i a")}}</td>

                                    <td>
                                        @if ($item->ratings)
                                 
                                            @php $rating = $item->ratings->value; @endphp
                                            <div class="overlay" style="text-align:center; color:rgb(241, 229, 56);">
                                            @while($rating>0)
                                            <i class="las la-star"></i>
                                            @php $rating--; @endphp
                                            @endwhile
                                            ({{$item->ratings->value}})
                                           </div>
                                           @else
                                           <p>Not Yet Rated</p>
                                       @endif
                                   </td>

                                    <td class="td" style="display: flex; justify-content: center;"> 
                                        <a href="{{route('admin.support.reply')}}?id={{$item->id}}"><button class="btn btn-sm btn-secondary" style="margin: 3px;"> @include('billal::svg.message')</button></a>
                                        <a href="{{route('admin.support.show')}}?id={{$item->id}}"><button class="btn btn-sm btn-flat btn-danger" data-toggle="tooltip" title="Show Ticket" style="margin: 3px;"><i class="la la-eye"></i></button></a>
                                        <form method="POST" action="{{ route('admin.support.delete', $item->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-primary btn-flat show_confirm" data-toggle="tooltip" title='Delete Ticket' style="margin: 3px;"><span class="las la-trash"></span></button>
                                      </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                            
                      </table>
                      {{$data->links()}} 
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
</div>
@endsection


