@extends('layouts.master')
@section('content')
 <section class="m-profile setting-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="library-full_card">
                        <div class="sign-user_card text-center">  
                        <div class="image-change">
                            @if(count($user->images)>0)
                                <img src="{{url('storage/'.$user->images[0]->thumbnail)}}" class="img-fluid d-block mx-auto mb-3" alt="{{$user->name}}" id="image">
                            @else
                                <img src="{{ Gravatar::src('https://www.gravatar.com/avatar/', 150) }}" class="img-fluid d-block mx-auto mb-3" alt="{{$user->name}}" id="image">
                                {{--  <img src="https://visualpharm.com/assets/30/User-595b40b85ba036ed117da56f.svg" class="img-fluid d-block mx-auto mb-3" alt="{{$user->name}}" id="image">  --}}
                            @endif

                                {{-- <input name="image"class="form_gallery-upload" type="file" accept=".png, .jpg, .jpeg" value="{{ old('image') }}" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" > --}}
                        </div>
                        <h4 class="my-3">{{$user->name}}</h4>                      
                            @include('member.profile.common.member-profile-menu')
                        </div>

                    </div>

                </div>

                <div class="col-lg-9">
                    <div class="pb-5">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th>Support #</th>
                                      <th>Status</th>
                                      <th>Message</th>
                                      <th>Last Updated</th>
                                      <th>Rating</th>
                                      <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($data as $item)
                                  <tr>
                                        <td>{{$item->department}}</td>
                                        @if ($item->status == 'Open')
                                        <td><span class="badge badge-info">{{$item->status}}</span></td>
                                        @elseif ($item->status == 'Closed')
                                        <td><span class="badge badge-danger">{{$item->status}}</span></td>
                                        @elseif ($item->status == 'Answered' )
                                        <td><span class="badge badge-warning">{{$item->status}}</span></td>
                                        @endif
                                        <td>
                                          <a href="{{route('member.auth.reply.template',[app()->getLocale()])}}?id={{$item->id}}"> @include('billal::svg.message')</a>
                                        </td>
                                        <td style="width:25%;">{{$item->updated_at->format("j F, Y : g:i a")}}</td>

                                        <td>
                                            @if ($item->ratings)
                                     
                                                @php $rating = $item->ratings->value; @endphp
                                                <div class="overlay" style="color:rgb(241, 229, 56);">
                                                @while($rating>0)
                                                <i class="fas fa-star"></i>
                                                @php $rating--; @endphp
                                                @endwhile
                                                ({{$item->ratings->value}})
                                               </div>
                                               @else
                                               <p>Not Yet Rated</p>
                                           @endif
                                       </td>
                                       
                                        @if($item->status != 'Closed')
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Option
                                                </button>
                                                <ul class="dropdown-menu">
                                                  <a class="dropdown-item" href="{{route('member.auth.reply.template',[app()->getLocale()])}}?id={{$item->id}}">View</a>
                                                  <a class="dropdown-item"  href="#"> <form action="{{ route('member.auth.ticket.status',[app()->getLocale()])}}?id={{$item->id}}" method="post" id="Form">
                                                    @csrf
                                                    <input type="hidden" name="status" value="Closed">
                                                    <button type="button" onclick="myFunction()" >Closed</button>
                                                   </form>
                                                  </a>
                                                </ul>
                                            </div>
                                        </td>
                                        @else
                                        <td>
                                            <button class="btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Option
                                              </button>
                                              <ul class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('member.auth.reply.template',[app()->getLocale()])}}?id={{$item->id}}">View</a>
                                              </ul>
                                        </td>
                                        @endif  
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div> {{$data->links()}} </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
@push('styles')
<style>
    
    td{border-bottom: 2px solid #404346;}
    .table thead th {border-bottom: 2px solid #404346;}
    .table-hover tbody tr:hover td {
    background: rgb(40, 41, 41);
    color: rgb(255, 255, 255)
    }
    .page-link{color: #000;}
    .page-item.active .page-link {
    background-color: #191919;
    border-color: #191919;
    }
    .table thead{background-color: #30302c;}
    .dropdown-menu .dropdown-item:hover {color: #c47c1e;}
 
 </style>
@endpush
<script>
    function myFunction()
                      {
                          Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You want to Close It!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, Close it!'
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire(
                                        'Closed!',
                                        'Your Ticket has been Closed.',
                                        'success'
                                        )
                                        $('#Form').submit();
                                    }
                                })
                            }                          
</script>

