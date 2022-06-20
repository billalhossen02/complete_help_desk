@extends('layouts.app')

@section('content')
<div id="content-page" class="content-page">
    <div class="container-fluid">
       <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10">
            <div class="card">
                <div class="card-header">
                    <h1>Ticket No #{{ $data->id }}</h1>
                    @if($data->status != 'Closed') 
                    <h1 style="position:absolute; right:0; margin-right:12px; top:15px; cursor:pointer" id="ticketH1" onclick="openForm()">...</h1>
                   <form action="{{route('admin.support.update')}}?id={{ $data->id }}" method="POST" enctype="multipart/form-data" id="ticketForm">
                         @csrf
                         <div class="form-group" style="position:absolute; right:0; margin-right:12px; top:15px">
                           <select id="ticketStatus" name='status' onchange="updateStatus()" class="form-control" style="height: 30px;font-size: 12px;" >
                               <option value="Open" style="background-color: #000">Open</option>
                               <option value="Closed" style="background-color: #000">Closed</option>
                             </select>
                           </div>
                     </form> 
                     @endif
                    <hr>
                </div>

                <div class="card-body">

                    <div class="message-group right">
                        <img src="{{ asset('avatar/unisex1.jpg') }}"
                              class="rounded-circle message-img" width="40" height="40">

                          <div class="message-single">
                              <div class="text-muted small text-nowrap">
                                  <b><strong>{{ $data->user_name }}(Member)</strong></b><br>
                                  {{ date('d-M-y h:i A', strtotime($data->created_at)) }}
                              </div>
                              {{ $data->message }}<br>
                              @if ($data->attachment)
                                  <div class="mesage-attachment">
                                          @if (pathinfo($data->attachment, PATHINFO_EXTENSION) != 'pdf')
                                            <img class="lightboxed" src="{{ domain('').$data->attachment }}" alt="">
                                          @else
                                              <a class="ma-pdf"
                                                  href="{{ domain('').$data->attachment}}"
                                                  target="_blank" title="Attachment">
                                                   @include('billal::svg.pdf')
                                              </a>
                                          @endif
                                    </div>
                              @endif
                          </div>
                      </div>

                    @foreach ($data->details as $item)
                        <div class="chat-message-left pb-4">
                            <div class="row">
                                
                                <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                    @php
                                        $side = 'right';
                                        $link = domain('');
                                        $name = ($item->member)? $item->member->name.'(Member)':  $item->user->name.'(Admin)';

                                        if($item->user_id != 0) {
                                            $side = 'left';
                                            $link = asset('').'storage/';
                                        }
                                    @endphp
                                    
                                    <div class="message-group {{ $side }}">
                                        <img src="{{ asset('avatar/unisex1.jpg') }}"
                                            class="rounded-circle message-img" alt="Admin" width="40" height="40">

                                        <div class="message-single">
                                            <div class="text-muted small text-nowrap">
                                                <b><strong>{{ $name }}</strong></b><br>
                                                {{ date('d-M-y h:i A', strtotime($item->created_at)) }}
                                            </div>
                                            @if($item->message) {{ $item->message }}<br> @endif
                                            @if ($item->attachment)
                                                <div class="mesage-attachment">
                                                    @foreach (explode('|', $item->attachment) as $key => $image)
                                                        @if (pathinfo($image, PATHINFO_EXTENSION) != 'pdf')
                                                          <img  class="lightboxed" rel="group1"  src="{{ $link . $image }}" data-link="{{ $link . $image }}">
                                                        @else
                                                            <a class="ma-pdf"
                                                                href="{{ $link . $image }}"
                                                                target="_blank" title="Attachment">
                                                                 @include('billal::svg.pdf')
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="card-footer">
                    @if ($data->status !== 'Closed')

                        <form class="form-left" action="{{route('admin.support.reply.msg')}}?id={{ $data->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div id="main">
                                <div class="img">
                                        <div class="image-upload">
                                            <label for="file-input">
                                                <i class="las la-2x la-image" style="cursor: pointer; margin-top: 9px;"></i>
                                            </label>
                                            <input id="file-input" type="file" accept=".jpg,.png,.pdf" name="attachment[]"  multiple/>
                                        </div>
                                </div>
                                <div class="msg">
                                        <input name="message" type="text" class="form-control" id="exampleFormControlTextarea4" placeholder="Message"
                                            style="border-radius:25px;
                                            "></input>

                                </div>
                                <div class="subbtn">
                                        <button type="submit" class="btn-lg btn-secondary"style="border-radius:30px;" ><i class="ri-send-plane-fill" ></i></button>

                                </div>
                                </div>
                          
                        </form>
                    @else
                        @if ($data->ratings)
                            <div style="text-align:center;">
                                <td>{{ $data->ratings->comment }}</td>
                            </div>
                            @php $rating = $data->ratings->value; @endphp
                                <div class="overlay" style="text-align:center; color:rgb(241, 229, 56);">
                                 @while($rating>0)
                                 <i class="las la-star"></i>
                                 @php $rating--; @endphp
                                 @endwhile
                                 ({{$data->ratings->value}}) out of 5
                                </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

