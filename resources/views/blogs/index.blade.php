@extends('layouts.master')

@section('content')
    @auth
    @if(auth()->user()->role == 'admin')
    <a href="{{route('blogs.create')}}">Add New Blog</a>
    @endif
    @endauth
    <h1 class="fw-bolder mb-1">Welcome to Blog Post!</h1>
    <div class="col-md-9">
    <div class="card-body">
    <div class="post">
    @foreach($blogs as $blog)

                    <!-- Post content-->

                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->

                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="{{asset('templet/dist/img/user1-128x128.jpg')}}" alt="user image">
                                <span class="username">
                      Admin 1
                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                   </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">Posted on January 1, 2023 by Start Bootstrap</div>
                            <!-- Post categories-->

                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" style="width: 100%; height: 300px; object-fit: cover;">
                        </figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p>{{ $blog->content }}</p>
                        </section>
                    </article>
                    <p>{{ $blog->likes()->count() }} likes</p>
                    @auth
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

                            @if(auth()->user()->role == 'admin')
                                <a class="btn btn-danger" href="{{route('blogs.edit',$blog->id)}}">Edit</a>

                                <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه المدونة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                    @endauth
                            <!-- Comments section-->
                            <section class="mb-5">
                                <div class="card bg-light">
                                    <div class="card-body">

                                        <!-- Comment form-->
                                        @auth
                                        @if(auth()->user()->role != 'admin')

                                                <form action="{{ route('comments.store', $blog->id) }}" method="POST" class="mb-4">
                                                    @csrf
                                                    <textarea name="content"  class="form-control" rows="3" placeholder="Join the discussion and leave a comment!"></textarea>
                                                    <button type="submit">Submit</button>
                                                </form>




                                        @endif
                                        @endauth
                                        <!-- Comment with nested comments-->


                                            @foreach($blog->comments as $comment)
                                                <!-- Parent comment-->

                                                <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>

                                                    <div class="fw-bold">{{ $comment->user->name }}</div>
                                                    {{ $comment->content }}
                                                        @auth
                                                    @if(auth()->id()==$comment->user->id)
                                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا التعليق؟');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    @endif
                                                    @endauth

                                        @endforeach

                            </section>

                            @endforeach
    </div>
    </div>
    </div>
            @section('links')
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
                <!-- Core theme JS-->
                <script src="{{asset('templet/js/scripts.js')}}"></script>
                <!-- Core theme CSS (includes Bootstrap)-->
                <link href="{{asset('templet/css/styles.css')}}" rel="stylesheet" />
            @endsection




        @endsection
