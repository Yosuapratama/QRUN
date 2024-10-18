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
                    <button type="submit" class="btn btn-success" >Create</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Add Event Modal In Admin Page --}}
<div class="modal fade" id="addEventModalAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <select name="placeCode" id="placeSelectCode" class="form-select" style="width:100%"></select>
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
                    <button type="submit" class="btn btn-success" >Create</button>
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
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">Edit Event
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                
                <div class="modal-body">
                    <input type="hidden" name="EventId" id="EventId">
                    <div class="mb-3">
                        <label for="detailTitleEventEdit" class="form-label">Title</label>
                        <input id="detailTitleEventEdit" name="title" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="descriptionEventEdit" class="form-label">Description</label>
                        <input id="descriptionEventEdit" name="description" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="datetimeEventEdit" class="form-label">Event DateTime (WITA)</label>
                        <input id="datetimeEventEdit" name="datetime" type="datetime-local" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" >Update Event</button>
                </div>

            </form>
        </div>
    </div>
</div>