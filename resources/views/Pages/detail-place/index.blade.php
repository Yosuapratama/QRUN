@extends('TemplateLayout.NormalLayout')

@push('title')
    <title>QRUN - {{ $place->title }}</title>
@endpush

@section('content')
    <div class="container-fluid overflow-x-hidden">
        <div id="app">

            <!-- Page Heading -->
            <h1 class="h3 text-gray-900 font-weight-bold m-2">DETAIL PLACE</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4" style="overflow-x: scroll">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Title : {{ $place->title }}</h6>
                    <small class="font-weight-bold text-gray-900">{{ $place->description }} | Created At :
                        {{ $place->created_at }} | <i class="fa-regular fa-eye"></i> {{ $place->views }}</small>
                </div>
                <div class="card-body m-2" style="overflow-x: scroll !important;">
                    {!! $place->content !!}
                </div>

                @if ($event)
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Upcoming Event</h6>
                        <small class="font-weight-bold text-gray-900">Next Event</small>
                    </div>
                    <div class="card-body m-2">
                        <div class="d-flex flex-wrap">
                            @foreach ($event as $evnt)
                                <div class="card-header p-2 m-2 rounded text-gray-900 font-weight-bold">
                                    <p class="m-0 font-weight-bold text-primary">{{ $evnt->title }}</p>
                                    <hr class="sidebar-divider">
                                    <p class="font-weight-bold text-gray-900">{{ $evnt->date->format('Y M d | H:i') }} Wita
                                    </p>
                                    <p></p>
                                    <small>{{ $evnt->description }}</small>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endif
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Comments</h6>
                    <small class="font-weight-bold text-gray-900">Before posting, make sure your comment is clear and does
                        not contain inappropriate language.</small>
                    <p class="alert alert-warning mt-2"><small>by using and accessing qrun services you are subject to terms of service</small></p>
                </div>
                <div class="card-body">
                    @if ($place->is_comment)
                        @if (Auth::check())
                            {{-- <form v-if="!editUserId" @submit.prevent="addComment"> --}}
                            <form v-if="editUserId" @submit.prevent="updateComment">
                                <div>
                                    <span v-for="n in 5" :key="n"
                                        :class="['star', { 'fas': n <= selectedRating, 'far': n > selectedRating }]"
                                        @click="setRating(n)" @mouseover="hoverRating(n)" @mouseleave="resetHover">
                                        <i class="fa fa-star"></i>
                                    </span>
                                </div>
                                <div v-if="selectedRating > 0">
                                    <p class="mt-2">You have selected @{{ selectedRating }} out of 5 stars!</p>
                                </div>

                                <div v-if="isReplying" class="alert alert-primary mt-2">
                                    <p>You are replying @{{ userReplying.name }} <button class="btn btn-primary mt-1"
                                            @click="cancelReply">Cancel Reply</button></p>
                                </div>
                                <div v-if="editUserId" class="alert alert-primary mt-2">
                                    <p>You are in editing mode <button class="btn btn-primary mt-1"
                                            @click="cancelEdit">Cancel Edit</button></p>
                                </div>

                                {{-- <div class="alert alert-primary" v-if="editUserId">Editing Your Comment</div> --}}
                                <div
                                    style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top:5px;">
                                    <input ref="inputField" v-model="currentComment" type="text" class="form-control">
                                    <input type="hidden" v-model="currEditId" name="id">
                                    <button type="submit" class="btn btn-primary mt-0" style="width: 100px"
                                        v-if="!editUserId">Post</button>
                                    <button type="submit" class="btn btn-primary mt-0" style="width: 100px"
                                        v-if="editUserId">Update</button>
                                </div>
                            </form>
                            <form v-if="!editUserId" @submit.prevent="addComment">
                                <div>
                                    <span v-for="n in 5" :key="n"
                                        :class="['star', { 'fas': n <= selectedRating, 'far': n > selectedRating }]"
                                        @click="setRating(n)" @mouseover="hoverRating(n)" @mouseleave="resetHover">
                                        <i class="fa fa-star"></i>
                                    </span>
                                </div>
                                <div v-if="selectedRating > 0">
                                    <p class="mt-2">You have selected @{{ selectedRating }} out of 5 stars!</p>
                                </div>

                                <div v-if="isReplying" class="alert alert-primary mt-2">
                                    <p>You are replying @{{ userReplying.name }} <button class="btn btn-primary mt-1"
                                            @click="cancelReply">Cancel Reply</button></p>
                                </div>
                                <div v-if="editUserId" class="alert alert-primary mt-2">
                                    <p>You are in editing mode <button class="btn btn-primary mt-1"
                                            @click="cancelEdit">Cancel Edit</button></p>
                                </div>

                                {{-- <div class="alert alert-primary" v-if="editUserId">Editing Your Comment</div> --}}
                                <div
                                    style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top:5px;">
                                    <input ref="inputField" v-model="currentComment" type="text" class="form-control">
                                    <input type="hidden" v-model="currEditId" name="id">
                                    <button type="submit" class="btn btn-primary mt-0" style="width: 100px"
                                        v-if="!editUserId">Post</button>
                                    <button type="submit" class="btn btn-primary mt-0" style="width: 100px"
                                        v-if="editUserId">Update</button>
                                </div>
                            </form>
                        @else
                            <div class="alert alert-primary">
                                <p>You Must login first before post/reply a comment</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">Login Now</a>
                            </div>
                        @endif
                        <div v-if="isLoadingComment">Please Wait...</div>
                        <p v-if="comments.length > 0 && !isLoadingComment">Average Rating : </p>
                        <p v-if="comments.length < 1 && !isLoadingComment">No comments data</p>
                        <div class="p-3 rounded alert-primary mt-3" v-for="item in comments"
                            v-if="comments.length > 0 && !isLoadingComment">
                            <span v-for="n in item.rating" :key="n" :class="['star fas']">
                                <i class="fa fa-star"></i>
                            </span>
                            <p style="font-size: 16px;">@{{ item.comment }}</p>
                            @if (Auth::check())
                                <button class="btn btn-success mt-0"
                                    @click="setReplyComment(item.id, item.user)">Reply</button>

                                <button v-if="userId == item.user.id" class="btn btn-danger mt-0"
                                    @click="deleteComments(item.id)">Delete</button>
                                <button v-if="userId == item.user.id" class="btn btn-primary mt-0"
                                    @click="editComments(item.id, item.comment, item.user)"><i
                                        class="fa-solid fa-pen"></i></button>
                            @endif
                            <div>
                                <span style="font-size: 13px;">@@{{ item.user?.name }}</span>
                            </div>
                            <div class="card-body bg-white rounded mt-2" v-for="reply in item.replies"
                                v-if="item.replies.length > 0">
                                <p style="font-size: 16px;">@{{ reply.comment }}</p>
                                <div>
                                    <span style="font-size: 13px;">@@{{ reply.user?.name }}</span>
                                </div>
                                @if (Auth::check())
                                    <button class="btn btn-success mt-2"
                                        @click="setReplyComment(reply.id, reply.user)">Reply</button>

                                    <button v-if="userId == reply.user.id" class="btn btn-danger mt-2"
                                        @click="deleteComments(reply.id)">Delete</button>
                                    <button v-if="userId == reply.user.id" class="btn btn-primary mt-2"
                                        @click="editComments(reply.id, reply.comment, reply.user)"><i
                                            class="fa-solid fa-pen"></i></button>
                                @endif

                                <div class="card-body alert alert-primary rounded mt-2" v-for="reply2 in reply.replies">
                                    <p>@{{ reply2.comment }}</p>
                                    <div>
                                        <span style="font-size: 13px;">@@{{ reply2?.user?.name }}</span>
                                    </div>

                                    @if (Auth::check())
                                        <button class="btn btn-success mt-2"
                                            @click="setReplyComment(reply2.id, reply2.user)">Reply</button>

                                        <button v-if="userId == reply2.user.id" class="btn btn-danger mt-2"
                                            @click="deleteComments(reply2.id)">Delete</button>
                                        <button v-if="userId == reply2.user.id" class="btn btn-primary mt-2"
                                            @click="editComments(reply2.id, reply2.comment, reply2.user)"><i
                                                class="fa-solid fa-pen"></i></button>
                                    @endif

                                    <div class="card-body bg bg-white rounded mt-2" v-for="reply3 in reply2.replies">
                                        <p>@{{ reply3.comment }}</p>
                                        <div>
                                            <span style="font-size: 13px;">@@{{ reply3?.user?.name }}</span>
                                        </div>

                                        @if (Auth::check())
                                            <button class="btn btn-success mt-2"
                                                @click="setReplyComment(reply3.id, reply3.user)">Reply</button>

                                            <button v-if="userId == reply3.user.id" class="btn btn-danger mt-2"
                                                @click="deleteComments(reply3.id)">Delete</button>
                                            <button v-if="userId == reply3.user.id" class="btn btn-primary mt-2"
                                                @click="editComments(reply3.id, reply3.comment, reply3.user)"><i
                                                    class="fa-solid fa-pen"></i></button>
                                        @endif

                                        <div class="card-body alert alert-primary rounded mt-2"
                                            v-for="reply4 in reply3.replies">
                                            <p>@{{ reply4.comment }}</p>
                                            <div>
                                                <span style="font-size: 13px;">@@{{ reply4?.user?.name }}</span>
                                            </div>

                                            @if (Auth::check())
                                                <button class="btn btn-success mt-2"
                                                    @click="setReplyComment(reply4.id, reply4.user)">Reply</button>

                                                <button v-if="userId == reply4.user.id" class="btn btn-danger mt-2"
                                                    @click="deleteComments(reply4.id)">Delete</button>
                                                <button v-if="userId == reply4.user.id" class="btn btn-primary mt-2"
                                                    @click="editComments(reply4.id, reply4.comment, reply4.user)"><i
                                                        class="fa-solid fa-pen"></i></button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button v-if="!isLoadingComment && currentPage > 1" @click="fetchNewDecrementData"
                            class="btn btn-primary">Back</button>
                        <button v-if="!isLoadingComment && currentPage != last_page" class="btn btn-primary"
                            @click="fetchNewData">Next</button>
                        <div v-if="isLoadingComment" class="spinner-border text-primary" role="status"
                            style="width: 1.5rem; height: 1.5rem;"></div>
                    @else
                        <p>Comment has disabled by author</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <style scoped>
        /* Basic styling for stars */
        .star {
            font-size: 20px;
            cursor: pointer;
            color: #ccc;
            /* Light grey color by default */
            margin-right: 5px;
        }

        .star.fas {
            color: #f39c12;
            /* Yellow color for filled stars */
        }

        .star.far {
            color: #ccc;
            /* Grey color for unfilled stars */
        }

        button {
            margin-top: 20px;
            padding: 8px 16px;
            cursor: pointer;
        }

        button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
    </style>
@endsection


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        // Initialize Vue without jQuery
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    comments: [],
                    selectedRating: 0, // Initial selected rating
                    hoveredRating: 0,
                    isLoadingComment: true,
                    currentPage: 1,
                    currentComment: null,
                    last_page: 0,
                    isReplying: null,
                    userReplying: null,
                    userId: null,
                    editUserId: null,
                    currEditId: null
                    // Rating on hover
                }
            },
            methods: {
                setRating(rating) {
                    this.selectedRating = rating;
                },
                // Set hover rating when mouse is over a star
                hoverRating(rating) {
                    this.hoveredRating = rating;
                },
                // Reset hover rating when mouse leaves the stars
                resetHover() {
                    this.hoveredRating = 0;
                },
                fetchNewDecrementData() {
                    this.currentPage--;
                    this.getCommentData();
                },
                fetchNewData() {
                    this.currentPage++;
                    this.getCommentData();
                },
                updateComment() {
                    const data = {
                        comment_id: this.currEditId,
                        comment: this.currentComment,
                        userId: this.userId
                    }

                    console.log(data);

                    const baseUrl = window.location.href;

                    const res = fetch(`${baseUrl}/comments/update`, {
                            method: 'POST', // Set the HTTP method to POST
                            headers: {
                                'Content-Type': 'application/json', // Tell the server the body is JSON
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.errors) {
                                swal("Error!", "Invalid Fields !",
                                    "error")
                            } else {
                                swal("Edited!", "Your comment has been edited.", "success");
                            }
                            this.isLoadingComment = false;
                            this.getCommentData();
                            this.cancelEdit();
                            this.currentComment = null;
                            this.isReplying = null;
                            this.userReplying = null;
                        })
                        .catch(error => swal("Error!", "Server Failed to Edit comment !",
                            "error"));

                },
                editComments(idComment, comment, userId) {
                    this.cancelReply();
                    this.currEditId = idComment;
                    // console.log(comment);
                    this.currentComment = comment;
                    this.editUserId = userId;
                    this.$refs.inputField.focus();
                },
                cancelEdit() {
                    this.currentComment = '';
                    this.editUserId = false;
                },
                async getCommentData() {
                    this.isLoadingComment = true;
                    // Simulate an async operation, like an API call
                    // Here we're just directly setting the comments
                    const baseUrl = window.location.href;

                    const res = await fetch(`${baseUrl}/comments?type=api&page=${this.currentPage}`)
                        .then(response => response.json())
                        .then(data => {
                            this.comments = data.data.data;
                            this.isLoadingComment = false;
                            this.last_page = data.data.last_page;
                            this.userId = data.uid;
                        })
                        .catch(error => console.error('Error fetching comments:', error));
                },
                addComment() {
                    this.isLoadingComment = true;
                    const baseUrl = window.location.href;

                    const data = {
                        rating: this.selectedRating,
                        comment: this.currentComment,
                        parent_id: this.isReplying
                    }
                    console.log(data);

                    const res = fetch(`${baseUrl}/comments/store?type=api`, {
                            method: 'POST', // Set the HTTP method to POST
                            headers: {
                                'Content-Type': 'application/json', // Tell the server the body is JSON
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.errors) {
                                swal("Error!", "Invalid Fields !",
                                    "error")
                            } else {
                                swal("Added!", "Your comment has been added.", "success");
                            }
                            this.isLoadingComment = false;
                            this.getCommentData();
                            this.currentComment = null;
                            this.isReplying = null;
                            this.userReplying = null;
                        })
                        .catch(error => swal("Error!", "Server Failed to add comment !",
                            "error"));
                },
                setReplyComment(id, user) {
                    console.log(id, user);
                    this.cancelEdit();
                    this.$refs.inputField.focus();
                    this.isReplying = id;
                    this.userReplying = user;
                },
                cancelReply() {
                    this.currEditId = null;
                    this.isReplying = null;
                    this.userReplying = null;
                },
                deleteComments(commentId) {
                    console.log(commentId);
                    swal({
                            title: "Are you sure?",
                            text: "Once deleted, you will not be able to recover this comment!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                this.isLoadingComment = true;
                                const baseUrl = window.location.href;

                                const res = fetch(`${baseUrl}/comments/${commentId}/delete`, {
                                        method: 'POST', // Set the HTTP method to POST
                                        headers: {
                                            'Content-Type': 'application/json', // Tell the server the body is JSON
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute('content')
                                        }
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        this.isLoadingComment = false;
                                        this.getCommentData();
                                        this.currentComment = null;
                                        this.isReplying = null;
                                        this.userReplying = null;

                                        // Show success message
                                        swal("Deleted!", "Your comment has been deleted.", "success");
                                    })
                                    .catch(error => {
                                        this.isLoadingComment = false;
                                        console.error('Error fetching comments:', error);
                                        swal("Error!", "There was a problem deleting your comment.",
                                            "error");
                                    });
                            } else {
                                // If the user canceled, show a message
                                swal("Your comment is safe!");
                            }
                        });
                }
            },
            mounted() {
                // Use a proper lifecycle method to ensure data has been updated
                this.getCommentData().then(() => {
                    // console.log(this.userId); // Logs updated comments
                });
            }
        });
    </script>
@endpush
