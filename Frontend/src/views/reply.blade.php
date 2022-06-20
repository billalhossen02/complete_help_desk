@extends('layouts.master')
@section('content')
    <section class="m-profile setting-wrapper reply-section">
        <div class="container-fluid">
            <div class="row" style="margin-left:-13px; margin-right:-25px;display: flex;">
                <div class="col-lg-3 col-md-3 col-sm-3 mb-3">
                    <div class="library-full_card">
                        <div class="sign-user_card text-center">
                            <div class="image-change">
                                @if (count($user->images) > 0)
                                    <img src="{{ url('storage/' . $user->images[0]->thumbnail) }}"
                                        class="img-fluid d-block mx-auto mb-3" alt="{{ $user->name }}" id="image">
                                @else
                                    <img src="{{ Gravatar::src('https://www.gravatar.com/avatar/', 150) }}"
                                        class="img-fluid d-block mx-auto mb-3" alt="{{ $user->name }}" id="image">
                                @endif
                                {{-- <input name="image" class="form_gallery-upload" type="file" accept=".png, .jpg, .jpeg"
                                    value="{{ old('image') }}"
                                    onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"> --}}
                            </div>
                            <h4 class="my-3">{{ $user->name }}</h4>
                            @include('member.profile.common.member-profile-menu')
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-9">

                    <div class="card">

                        <div class="card-header" style="background-color: rgba(10, 10, 10, 0.408)">
                            <div class="row">
                            <h1>Ticket No #{{ $data->id }}</h1>
                          @if($data->status != 'Closed') 
                           <h1 style="position:absolute; right:0; margin-right:12px; cursor:pointer" id="ticketH1" onclick="openForm()">...</h1>
                          <form action="{{ route('member.auth.ticket.status',[app()->getLocale()]) }}?id={{ $data->id }}" method="POST" enctype="multipart/form-data" id="ticketForm">
                                @csrf
                                <div class="form-group" style="position:absolute; right:0; margin-right:12px;">
                                  <select id="ticketStatus" name='status' onchange="updateStatus()" class="form-control" style="height: 30px;font-size: 12px;" >
                                      <option value="Open" style="background-color: #000">Open</option>
                                      <option value="Closed" style="background-color: #000">Closed</option>
                                    </select>
                                  </div>
                            </form> 
                            @endif
                            <hr>
                         </div>
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
                                                    <img class="lightboxed" src="{{ url('storage/'.$data->attachment) }}" alt="">
                                                  @else
                                                      <a class="ma-pdf"
                                                          href="{{ url('storage/'.$data->attachment)}}"
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
                                                $link = url('') . '/';
                                                $name = ($item->member)? $item->member->name. '(Member)':  $item->user->name.'(Admin)';

                                                if($item->user_id != 0) {
                                                    $side = 'left';
                                                    $link = asset('');
                                                }

                                            @endphp
                                            
                                            <div class="message-group {{ $side }}">
                                              <img src="{{ asset('avatar/unisex1.jpg') }}"
                                                    class="rounded-circle message-img" width="40" height="40">

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
                                                                <img class="lightboxed" rel="group1" src="{{ $link . 'storage/' . $image }}" data-link="{{ $link . 'storage/' . $image }}" alt="" />
                                                                  @else
                                                                    <a class="ma-pdf"
                                                                        href="{{ $link . 'storage/' . $image }}"
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

                                <form
                                    action="{{ route('member.auth.user.reply', [app()->getLocale()]) }}?id={{ $data->id }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                                <div id="main">

                                                <div class="img">
                                                        <div class="image-upload">
                                                            <label for="file-input">
                                                                <i class="fas fa-2x fa-image" style="cursor: pointer; margin-top: 9px;"></i>
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
                                            <i class="fas fa-star"></i>
                                                @php $rating--; @endphp
                                         @endwhile
                                         ({{$data->ratings->value}}) out of 5
                                        </div>
                                @else
                                    <div class="rating-container">
                                        <div class="star-widget">
                                            <form
                                                action="{{ route('member.auth.rating', [app()->getLocale()]) }}?id={{ $data->id }}"
                                                method="post">
                                                @csrf
                                                <input type="radio" value="5" name="rating" id="rate-5">
                                                <label for="rate-5" class="fas fa-star"></label>
                                                <input type="radio" value="4" name="rating" id="rate-4">
                                                <label for="rate-4" class="fas fa-star"></label>
                                                <input type="radio" value="3" name="rating" id="rate-3">
                                                <label for="rate-3" class="fas fa-star"></label>
                                                <input type="radio" value="2" name="rating" id="rate-2">
                                                <label for="rate-2" class="fas fa-star"></label>
                                                <input type="radio" value="1" name="rating" id="rate-1">
                                                <label for="rate-1" class="fas fa-star"></label>

                                                <div class="textarea">
                                                    <textarea cols="30" name='comment' id="comment" placeholder="Describe your experience.."></textarea>
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

