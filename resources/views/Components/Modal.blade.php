{{-- Create New User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="createUserForm">
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">Add New Users
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="nameUser" class="form-label">Name</label>
                        <input id="nameUser" name="name" type="text" class="form-control" placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label for="addressUser" class="form-label">Address</label>
                        <textarea id="addressUser" name="address" class="form-control" placeholder="Address..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" name="phone" type="number" class="form-control"
                            placeholder="Phone...Ex: 0812">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email...">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control"
                            placeholder="Password...">
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Confirm Password</label>
                        <input id="password2" name="password2" type="password" class="form-control"
                            placeholder="Password...">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="submitCreateUser" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Detail User Modal --}}
<div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">User Detail
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="detailName" class="form-label">Name</label>
                        <input id="detailName" disabled name="name" type="text" class="form-control"
                            placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label for="detailAddress" class="form-label">Address</label>
                        <textarea disabled id="detailAddress" name="name" type="text" class="form-control" placeholder="Address..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="detailPhone" class="form-label">Phone</label>
                        <input id="detailPhone" disabled name="phone" type="text" class="form-control"
                            placeholder="Phone...Ex: 0812">
                    </div>
                    <div class="mb-3">
                        <label for="detailEmail" class="form-label">Email</label>
                        <input id="detailEmail" disabled name="email" type="email" class="form-control"
                            placeholder="Email...">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit User Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editUserForm">
                <input type="hidden" id="idUser" name="id">

                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">Edit User
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input id="editName" name="name" type="text" class="form-control"
                            placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">Address</label>
                        <textarea id="editAddress" name="address" type="text" class="form-control" placeholder="Address..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input id="editPhone" name="phone" type="text" class="form-control"
                            placeholder="Phone...Ex: 0812">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input id="editEmail" disabled name="email" type="email" class="form-control"
                            placeholder="Email...">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailPlaceModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">Place Detail
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="link"></div>
                    <div class="mb-3">
                        <label for="detailTitle" class="form-label">Title</label>
                        <input id="detailTitle" disabled name="name" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea disabled id="description" name="name" type="text" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="detailPhoneNumber" class="form-label">Phone Number</label>
                        <input id="detailPhoneNumber" disabled name="phonenum" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="created_by" class="form-label">Created_By</label>
                        <input id="created_by" disabled name="created_by" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="total_event" class="form-label">Total Event</label>
                        <input id="total_event" disabled name="event" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="updated_at" class="form-label">Updated_At</label>
                        <input id="updated_at" disabled name="email" type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="created_at" cslass="form-label">created_At</label>
                        <input id="created_at" disabled name="email" type="email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add Event Modal --}}

<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addEventForm">
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">
                        @lang('messages.my-event.add_event')
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="detailTitle" class="form-label">@lang('messages.my-event.title')<span
                                class="text-danger">*</span></label>
                        <input id="detailTitle" name="title" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">@lang('messages.my-event.description')<span
                                class="text-danger">*</span></label>
                        <input id="description" name="description" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="datetime" class="form-label">@lang('messages.my-event.datetime')<span
                                class="text-danger">*</span></label>
                        <input id="datetime" name="datetime" type="datetime-local" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">@lang('messages.global_close_button')</button>
                    <button type="submit" class="btn btn-success">@lang('messages.global_create_button')</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addEventModalAdminNew" tabindex="-1" role="dialog"
    aria-labelledby="addEventModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-xl">

            {{-- Header --}}
            <div class="modal-header border-0 bg-white px-4 py-4">
                <div>
                    <h4 class="font-weight-bold mb-1">
                        <i class="fas fa-calendar-plus text-primary mr-2"></i>
                        Add Event
                    </h4>

                    <small class="text-muted">
                        Create a new event for this place.
                    </small>
                </div>

                <button type="button" class="close shadow-none" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="addEventFormAdmin">

                @csrf

                <input type="hidden" name="place_id" value="{{ isset($Place) ? $Place->id : '' }}">

                <div class="modal-body px-4 py-3">

                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                Event Schedule
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="eventDateRange" class="form-control custom-input"
                                placeholder="Select event date range..." autocomplete="off">

                            {{-- hidden for backend --}}
                            <input type="hidden" name="datetime" id="eventStartDate">
                            <input type="hidden" name="end_date" id="eventEndDate">
                        </div>
                        

                        {{-- Event Title --}}
                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                Event Title
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" class="form-control custom-input" name="title"
                                placeholder="Enter event title..." required>
                        </div>

                        {{-- Description --}}
                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                Description
                            </label>

                            <textarea class="form-control custom-input" rows="5" name="description"
                                placeholder="Write event description..."></textarea>
                        </div>

                        {{-- Start Date --}}
                        <div class="col-12 mb-4">
                            {{-- Event Images --}}
                            <label class="font-weight-bold">
                                Event Images
                            </label>

                            <input type="file" class="form-control custom-input" id="eventImages" name="images[]"
                                accept="image/*" multiple>

                            <small class="text-muted d-block mt-2">
                                You can upload multiple images.
                            </small>

                            <div id="eventImagesPreview" class="row mt-3"></div>
                        </div>
                      
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0 bg-light px-4 py-3">

                    <button type="button" class="btn btn-light px-4 rounded-pill" data-dismiss="modal">

                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary shadow-sm px-4 rounded-pill">

                        <i class="fas fa-save mr-2"></i>
                        Save Event
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editEventModalAdminNew" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content border-0 shadow-lg rounded-xl">

            <div class="modal-header border-0 bg-white px-4 py-4">

                <div>
                    <h4 class="font-weight-bold mb-1">
                        <i class="fas fa-edit text-warning mr-2"></i>
                        Edit Event
                    </h4>

                    <small class="text-muted">
                        Update event information.
                    </small>
                </div>

                <button type="button" class="close shadow-none closeEditModal" data-dismiss="modal">

                    <span>&times;</span>
                </button>
            </div>

            <form id="editEventFormAdmin">

                @csrf

                <input type="hidden" name="EventId" id="eventIdEdit">

                <div class="modal-body px-4 py-3">

                    <div class="row">
                        
                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                Event Schedule
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="eventDateRangeEdit" class="form-control custom-input"
                                autocomplete="off">

                            <input type="hidden" name="datetime" id="dateEventEdit">

                            <input type="hidden" name="end_date" id="endDateEventEdit">
                        </div>


                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                Event Title
                            </label>

                            <input type="text" class="form-control custom-input" name="title"
                                id="titleEventEdit" required>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                Description
                            </label>

                            <textarea class="form-control custom-input" rows="5" name="description" id="descriptionEventEdit"></textarea>
                        </div>

                        {{-- Event Images --}}
                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                Event Images
                            </label>

                            <input type="file" class="form-control custom-input" id="eventImagesEdit"
                                name="images[]" accept="image/*" multiple>

                            <small class="text-muted d-block mt-2">
                                Upload new images if needed.
                            </small>

                            <div id="eventImagesPreviewEdit" class="row mt-3"></div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer border-0 bg-light px-4 py-3">

                    <button type="button" class="cancelEditModal btn btn-light rounded-pill px-4"
                        data-dismiss="modal">

                        Cancel
                    </button>

                    <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">

                        <i class="fas fa-save mr-2"></i>
                        Update Event
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cropImageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="font-weight-bold mb-0">
                    Crop Image
                </h5>

                <button
                    type="button"
                    class="close cropModalCloseBtn"
                >
                    <span>&times;</span>
                </button>

            </div>

            <div class="modal-body text-center">
                <img
                    id="cropperImage"
                    style="max-width:100%;"
                >
            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light cropModalCloseBtn"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="saveCropBtn"
                    class="btn btn-primary"
                >
                    Save Crop
                </button>

            </div>

        </div>
    </div>
</div>

{{-- Add Event Modal In Admin Page --}}
<div class="modal fade" id="addEventModalAdmin" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addEventForm">
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">Create Event
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="detailTitle" class="form-label">Title</label>
                        <input id="detailTitle" name="title" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label">Enter Place Code</label>
                        <select name="placeCode" id="placeSelectCode" class="form-select"
                            style="width:100%"></select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input id="description" name="description" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="datetime" class="form-label">Event DateTime (WITA)</label>
                        <input id="datetime" name="datetime" type="datetime-local" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Edit Event Modal --}}
<div class="modal fade" id="editEventModalAdmin" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editEventForm">
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">
                        @lang('messages.my-event.edit_event')
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="EventId" id="EventId">
                    <div class="mb-3">
                        <label for="detailTitleEventEdit" class="form-label">@lang('messages.my-event.title')<span
                                class="text-danger">*</span></label>
                        <input id="detailTitleEventEdit" name="title" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="descriptionEventEdit" class="form-label">@lang('messages.my-event.description')<span
                                class="text-danger">*</span></label>
                        <input id="descriptionEventEdit" name="description" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="datetimeEventEdit" class="form-label">@lang('messages.my-event.datetime')<span
                                class="text-danger">*</span></label>
                        <input id="datetimeEventEdit" name="datetime" type="datetime-local" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">@lang('messages.global_close_button')</button>
                    <button type="submit" class="btn btn-success">@lang('messages.global_edit_button')</button>
                </div>

            </form>
        </div>
    </div>
</div>
{{-- Add User has limit modal --}}
<div class="modal fade" id="addUserhasLimitModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addUserHasPlaceLimit">
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">Create User
                        has Place Limit
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label">Select User</label>
                        <select name="user" id="find-user" class="form-select" style="width:100%"></select>
                    </div>
                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label">Select Place Limit</label>
                        <select name="place_limit" id="find_place_limit" class="form-select"
                            style="width:100%"></select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Edit User has limit modal --}}
<div class="modal fade" id="editUserhasLimitModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editUserHasPlaceLimit">
                <input type="hidden" name="id" id="editUserHasLimitiD">
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">Edit User has
                        Place Limit
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label">Select User</label>
                        <select name="user" id="find-user-edit" class="form-select" style="width:100%"></select>
                    </div>
                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label">Select Place Limit</label>
                        <select name="place_limit" id="find_place_limit_edit" class="form-select"
                            style="width:100%"></select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>
