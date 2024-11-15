@extends('layouts.master')

@section('content')
    <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; width: 500px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        @if($blog->image)
            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="width: 100%; height: 300px; object-fit: cover;">
        @else
            <img src="{{ asset('images/default-blog.jpg') }}" alt="Default Blog Image" style="width: 100%; height: 300px; object-fit: cover;">
        @endif

        <div style="padding: 16px;">
            <h2>{{ $blog->title }}</h2>
            <p>{{ $blog->content }}</p>
            <p><strong>Status:</strong> {{ ucfirst($blog->status) }}</p>
        </div>
    </div>
    <p>{{ $blog->likes()->count() }} likes</p>
     @if(auth()->user()->role != 'admin')
    <form action="{{ route('blogs.like', $blog->id) }}" method="POST">
        @csrf
        @if(auth()->check() && auth()->user()->likedBlogs->contains($blog->id))
            <button type="submit"  class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                Unlike
            </button>
        @else
            <button type="submit"  class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                Like
            </button>
        @endif
    </form>
     @endif

    <h3>Comments</h3>
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div class="streamline m-b m-l">
                    <div class="sl-item">
            <div class="box-header">
                <h3>Comments <span class="label success"></span></h3>
            </div>
    @foreach($blog->comments as $comment)
        <div style="border: 1px solid #eee; padding: 10px; margin-bottom: 10px;">



                                <div class="sl-left">
                                    <img src="{{asset('templet/assets/images/a0.jpg')}}" class="img-circle">
                                </div>
                                <div class="sl-content">
                                    <div class="sl-date text-muted">2 minutes ago</div>
                                    <div class="sl-author">
                                        <a href>{{ $comment->user->name }}</a>
                                    </div>
                                    <div>
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    @if(auth()->id()==$comment->user->id)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه المدونة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    @endif
                                    <div class="sl-footer">
                                        <a href data-toggle="collapse" data-target="#reply-1">
                                            <i class="fa fa-fw fa-mail-reply text-muted"></i> Reply
                                        </a>
                                    </div>
                                    <div class="box collapse m-0 b-a" id="reply-1">
                                        <form>
                                            <textarea class="form-control no-border" rows="3" placeholder="Type something..."></textarea>
                                        </form>
                                        <div class="box-footer clearfix">
                                            <button class="btn btn-info pull-right btn-sm">Post</button>
                                            <ul class="nav nav-pills nav-sm">
                                                <li class="nav-item"><a class="nav-link" href><i class="fa fa-camera text-muted"></i></a></li>
                                                <li class="nav-item"><a class="nav-link" href><i class="fa fa-video-camera text-muted"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                @endforeach

                            </div>

                            <div class="sl-item">
                                @if(auth()->user()->role != 'admin')
                                    @auth

                                        <form action="{{ route('comments.store', $blog->id) }}" method="POST">
                                            @csrf

                                            <label for="content">Add a Comment:</label>
                                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment" name="content" required>
                                            <button type="submit">Submit</button>

                                        </form>
                                    @else
                                        <p>Please <a href="{{ route('login') }}">login</a> to add a comment.</p>


                                    @endauth

                                @endif






{{--    <script src="{{asset('templet/assets/libs/jquery/jquery/dist/jquery.js')}}"></script>--}}
{{--    <!-- Bootstrap -->--}}
{{--    <script src="{{asset('templet/assets/libs/jquery/tether/dist/js/tether.min.js')}}"></script>--}}
{{--    <script src="{{asset('templet/assets/libs/jquery/bootstrap/dist/js/bootstrap.js')}}"></script>--}}
{{--    <!-- core -->--}}
{{--    <script src="{{asset('templet/assets/libs/jquery/underscore/underscore-min.js')}}"></script>--}}
{{--    <script src="{{asset('templet/assets/libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js')}}"></script>--}}
{{--    <script src="{{asset('templet/assets/libs/jquery/PACE/pace.min.js')}}"></script>--}}

{{--    <script src="{{asset('templet/scripts/config.lazyload.js')}}"></script>--}}

{{--    <script src="{{asset('templet/scripts/palette.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-load.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-jp.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-include.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-device.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-form.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-nav.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-screenfull.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-scroll-to.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ui-toggle-class.js')}}"></script>--}}

{{--    <script src="{{asset('templet/scripts/app.js')}}"></script>--}}

{{--    <!-- ajax -->--}}
{{--    <script src="{{asset('templet/assets/libs/jquery/jquery-pjax/jquery.pjax.js')}}"></script>--}}
{{--    <script src="{{asset('templet/scripts/ajax.js)}}"></script>--}}
@endsection
