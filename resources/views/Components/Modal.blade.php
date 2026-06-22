{{-- Create New User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="createUserForm">
                <div class="modal-header">
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">{{ __('messages.management.modal.add_user_title') }}
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="nameUser" class="form-label">{{ __('messages.management.modal.field_name') }}</label>
                        <input id="nameUser" name="name" type="text" class="form-control" placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label for="addressUser" class="form-label">{{ __('messages.management.modal.field_address') }}</label>
                        <textarea id="addressUser" name="address" class="form-control" placeholder="Address..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">{{ __('messages.management.modal.field_phone') }}</label>
                        <input id="phone" name="phone" type="number" class="form-control"
                            placeholder="Phone...Ex: 0812">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('messages.management.modal.field_email') }}</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="Email...">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('messages.management.modal.field_password') }}</label>
                        <input id="password" name="password" type="password" class="form-control"
                            placeholder="Password...">
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">{{ __('messages.management.modal.field_confirm_password') }}</label>
                        <input id="password2" name="password2" type="password" class="form-control"
                            placeholder="Password...">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.management.modal.btn_close') }}</button>
                    <button id="submitCreateUser" type="submit" class="btn btn-primary">{{ __('messages.management.modal.btn_save') }}</button>
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
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">{{ __('messages.management.modal.detail_user_title') }}
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="detailName" class="form-label">{{ __('messages.management.modal.field_name') }}</label>
                        <input id="detailName" disabled name="name" type="text" class="form-control"
                            placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label for="detailAddress" class="form-label">{{ __('messages.management.modal.field_address') }}</label>
                        <textarea disabled id="detailAddress" name="name" type="text" class="form-control" placeholder="Address..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="detailPhone" class="form-label">{{ __('messages.management.modal.field_phone') }}</label>
                        <input id="detailPhone" disabled name="phone" type="text" class="form-control"
                            placeholder="Phone...Ex: 0812">
                    </div>
                    <div class="mb-3">
                        <label for="detailEmail" class="form-label">{{ __('messages.management.modal.field_email') }}</label>
                        <input id="detailEmail" disabled name="email" type="email" class="form-control"
                            placeholder="Email...">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.management.modal.btn_close') }}</button>
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
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">{{ __('messages.management.modal.edit_user_title') }}
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="editName" class="form-label">{{ __('messages.management.modal.field_name') }}</label>
                        <input id="editName" name="name" type="text" class="form-control"
                            placeholder="Name...">
                    </div>
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">{{ __('messages.management.modal.field_address') }}</label>
                        <textarea id="editAddress" name="address" type="text" class="form-control" placeholder="Address..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">{{ __('messages.management.modal.field_phone') }}</label>
                        <input id="editPhone" name="phone" type="text" class="form-control"
                            placeholder="Phone...Ex: 0812">
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">{{ __('messages.management.modal.field_email') }}</label>
                        <input id="editEmail" disabled name="email" type="email" class="form-control"
                            placeholder="Email...">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.management.modal.btn_close') }}</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">{{ __('messages.management.modal.btn_update') }}</button>
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
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">{{ __('messages.management.modal.detail_place_title') }}
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="link"></div>
                    <div class="mb-3">
                        <label for="detailTitle" class="form-label">{{ __('messages.management.modal.field_title') }}</label>
                        <input id="detailTitle" disabled name="name" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('messages.management.modal.field_description') }}</label>
                        <textarea disabled id="description" name="name" type="text" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="detailPhoneNumber" class="form-label">{{ __('messages.management.modal.field_phone_number') }}</label>
                        <input id="detailPhoneNumber" disabled name="phonenum" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="created_by" class="form-label">{{ __('messages.management.modal.field_created_by') }}</label>
                        <input id="created_by" disabled name="created_by" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="total_event" class="form-label">{{ __('messages.management.modal.field_total_event') }}</label>
                        <input id="total_event" disabled name="event" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="updated_at" class="form-label">{{ __('messages.management.modal.field_updated_at') }}</label>
                        <input id="updated_at" disabled name="email" type="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">{{ __('messages.management.modal.field_created_at') }}</label>
                        <input id="created_at" disabled name="email" type="email" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.management.modal.btn_close') }}</button>
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
                        {{ __('messages.management.modal.add_event_modal_title') }}
                    </h4>

                    <small class="text-muted">
                        {{ __('messages.management.modal.add_event_modal_subtitle') }}
                    </small>
                </div>

                <button type="button" class="close shadow-none closeAddModal" data-dismiss="modal"
                    aria-label="Close">

                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="addEventFormAdmin">

                @csrf
                @if (isset($Place))
                    <input type="hidden" name="place_id" value="{{ isset($Place) ? $Place->id : '' }}">
                @endif

                <div class="modal-body px-4 py-3">

                    <div class="row">

                        <div class="col-12 mb-4" id="addEventDateGroup">
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_event_schedule') }}
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="eventDateRange" class="form-control custom-input"
                                placeholder="Select event date range..." autocomplete="off">

                            {{-- hidden for backend --}}
                            <input type="hidden" name="datetime" id="eventStartDate">
                            <input type="hidden" name="end_date" id="eventEndDate">
                        </div>

                        {{-- PLACE SELECT --}}
                        <div class="col-12 mb-4" id="placeSelectWrapper" style="display:none;">
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_select_place') }}
                                <span class="text-danger">*</span>
                            </label>

                            <select class="form-control custom-input" id="placeSelectCode" name="place_code"
                                style="width: 100%;">

                                <option value="">{{ __('messages.management.modal.field_select_place') }}</option>
                            </select>

                            <small class="text-muted d-block mt-2">
                                {{ __('messages.management.modal.select_place_hint') }}
                            </small>
                        </div>

                        {{-- Event Title --}}
                        <div class="col-12 mb-4" id="addEventTitleGroup">
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_event_title') }}
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" class="form-control custom-input" name="title"
                                placeholder="Enter event title..." required>
                        </div>

                        {{-- Description --}}
                        <div class="col-12 mb-4" id="addEventDescGroup">
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_event_desc') }}
                            </label>

                            <textarea class="form-control custom-input" rows="5" name="description"
                                placeholder="Write event description..."></textarea>
                        </div>

                        {{-- Event Active Status --}}
                        <div class="col-12 mb-4" id="addEventStatusGroup">

                            <label class="font-weight-bold d-flex align-items-center justify-content-between">

                                <span>
                                    {{ __('messages.management.modal.field_event_active') }}
                                </span>

                                <span id="addEventStatusText" class="badge badge-success px-3 py-2">
                                    {{ __('messages.management.modal.badge_active') }}
                                </span>
                            </label>

                            <div class="custom-control custom-switch mt-2">

                                <input type="checkbox" class="custom-control-input" id="addEventIsActive"
                                    name="is_active" value="1" checked>

                                <label class="custom-control-label" for="addEventIsActive">

                                    {{ __('messages.management.modal.enable_event_label') }}
                                </label>
                            </div>

                            <small class="text-muted d-block mt-2">
                                {{ __('messages.management.modal.event_inactive_hint') }}
                            </small>
                        </div>

                        <div class="col-12 mb-4" id="addEventImagesGroup">
                            {{-- Event Images --}}
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_event_images') }}
                            </label>

                            <input type="file" class="form-control custom-input" id="eventImages" name="images[]"
                                accept="image/*" multiple>

                            <small class="text-muted d-block mt-2">
                                {{ __('messages.management.modal.upload_multi_hint') }}
                            </small>

                            <div id="eventImagesPreview" class="row mt-3"></div>
                        </div>

                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0 bg-light px-4 py-3" id="addEventFooter">

                    <button type="button" class="closeAddModal btn btn-light px-4 rounded-pill"
                        data-dismiss="modal" id="addEventCancelBtn">

                        {{ __('messages.management.modal.btn_cancel') }}
                    </button>

                    <button type="submit" class="btn btn-primary shadow-sm px-4 rounded-pill" id="addEventSubmitBtn">

                        <i class="fas fa-save mr-2"></i>
                        {{ __('messages.management.modal.btn_save_event') }}
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
                        {{ __('messages.management.modal.edit_event_modal_title') }}
                    </h4>

                    <small class="text-muted">
                        {{ __('messages.management.modal.edit_event_modal_subtitle') }}
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
                                {{ __('messages.management.modal.field_event_schedule') }}
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="eventDateRangeEdit" class="form-control custom-input"
                                autocomplete="off">

                            <input type="hidden" name="datetime" id="dateEventEdit">

                            <input type="hidden" name="end_date" id="endDateEventEdit">
                        </div>


                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_event_title') }}
                            </label>

                            <input type="text" class="form-control custom-input" name="title"
                                id="titleEventEdit" required>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_event_desc') }}
                            </label>

                            <textarea class="form-control custom-input" rows="5" name="description" id="descriptionEventEdit"></textarea>
                        </div>

                        {{-- Event Active Status --}}
                        <div class="col-12 mb-4">

                            <label class="font-weight-bold d-flex align-items-center justify-content-between">

                                <span>
                                    {{ __('messages.management.modal.field_event_active') }}
                                </span>

                                <span id="editEventStatusText" class="badge badge-success px-3 py-2">
                                    {{ __('messages.management.modal.badge_active') }}
                                </span>
                            </label>

                            <div class="custom-control custom-switch mt-2">

                                <input type="checkbox" class="custom-control-input" id="editEventIsActive"
                                    name="is_active" value="1" checked>

                                <label class="custom-control-label" for="editEventIsActive">

                                    {{ __('messages.management.modal.enable_event_label') }}
                                </label>
                            </div>

                            <small class="text-muted d-block mt-2">
                                {{ __('messages.management.modal.event_inactive_hint') }}
                            </small>
                        </div>

                        {{-- Event Images --}}
                        <div class="col-12 mb-4">
                            <label class="font-weight-bold">
                                {{ __('messages.management.modal.field_event_images') }}
                            </label>

                            <input type="file" class="form-control custom-input" id="eventImagesEdit"
                                name="images[]" accept="image/*" multiple>

                            <small class="text-muted d-block mt-2">
                                {{ __('messages.management.modal.upload_new_hint') }}
                            </small>

                            <div id="eventImagesPreviewEdit" class="row mt-3"></div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer border-0 bg-light px-4 py-3">

                    <button type="button" class="cancelEditModal btn btn-light rounded-pill px-4"
                        data-dismiss="modal">

                        {{ __('messages.management.modal.btn_cancel') }}
                    </button>

                    <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">

                        <i class="fas fa-save mr-2"></i>
                        {{ __('messages.management.modal.btn_update_event') }}
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
                    {{ __('messages.management.modal.crop_modal_title') }}
                </h5>

                <button type="button" class="close cropModalCloseBtn">
                    <span>&times;</span>
                </button>

            </div>

            <div class="modal-body text-center">
                <img id="cropperImage" style="max-width:100%;">
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-light cropModalCloseBtn">
                    {{ __('messages.management.modal.btn_cancel') }}
                </button>

                <button type="button" id="saveCropBtn" class="btn btn-primary">
                    {{ __('messages.management.modal.btn_save_crop') }}
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
                    <h4 style="color:#24396f;" class="fs-6 m-3 font-weight-bold" id="exampleModalLabel">{{ __('messages.management.modal.create_event_title') }}
                    </h4>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="detailTitle" class="form-label">{{ __('messages.management.modal.field_event_title') }}</label>
                        <input id="detailTitle" name="title" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label">{{ __('messages.management.modal.field_place_code') }}</label>
                        <select name="placeCode" id="placeSelectCode" class="form-select"
                            style="width:100%"></select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('messages.management.modal.field_event_desc') }}</label>
                        <input id="description" name="description" type="text" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="datetime" class="form-label">{{ __('messages.management.modal.field_datetime') }}</label>
                        <input id="datetime" name="datetime" type="datetime-local" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.management.modal.btn_close') }}</button>
                    <button type="submit" class="btn btn-success">{{ __('messages.management.modal.btn_create') }}</button>
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
{{-- Add User Place Limit Modal --}}
<div class="modal fade" id="addUserhasLimitModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addUserHasPlaceLimit">

                <div class="modal-header">
                    <div>
                        <h4 style="color:#24396f;" class="fs-5 m-0 font-weight-bold">
                            {{ __('messages.management.modal.add_limit_title') }}
                        </h4>

                        <small class="text-secondary">
                            {{ __('messages.management.modal.add_limit_subtitle') }}
                        </small>
                    </div>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        X
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-info small">
                        {{ __('messages.management.modal.add_limit_alert') }}
                    </div>

                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label font-weight-bold">
                            {{ __('messages.management.modal.field_select_user') }}
                        </label>

                        <select name="user" id="find-user" class="form-select" style="width:100%"></select>

                        <small class="text-secondary">
                            {{ __('messages.management.modal.select_user_hint_add') }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label font-weight-bold">
                            {{ __('messages.management.modal.field_select_place_limit') }}
                        </label>

                        <select name="place_limit" id="find_place_limit" class="form-select"
                            style="width:100%"></select>

                        <small class="text-secondary">
                            {{ __('messages.management.modal.select_limit_hint_add') }}
                        </small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('messages.management.modal.btn_close') }}
                    </button>

                    <button type="submit" class="btn btn-success">
                        {{ __('messages.management.modal.btn_create_limit') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Edit User Place Limit Modal --}}
<div class="modal fade" id="editUserhasLimitModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form id="editUserHasPlaceLimit">

                <input type="hidden" name="id" id="editUserHasLimitiD">

                <div class="modal-header">

                    <div>
                        <h4 style="color:#24396f;" class="fs-5 m-0 font-weight-bold">
                            {{ __('messages.management.modal.edit_limit_title') }}
                        </h4>

                        <small class="text-secondary">
                            {{ __('messages.management.modal.edit_limit_subtitle') }}
                        </small>
                    </div>

                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        X
                    </button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-warning small">
                        {{ __('messages.management.modal.edit_limit_alert') }}
                    </div>

                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label font-weight-bold">
                            {{ __('messages.management.modal.field_select_user') }}
                        </label>

                        <select name="user" id="find-user-edit" class="form-select" style="width:100%"></select>

                        <small class="text-secondary">
                            {{ __('messages.management.modal.select_user_hint_edit') }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="placeSelectCode" class="form-label font-weight-bold">
                            {{ __('messages.management.modal.field_select_place_limit') }}
                        </label>

                        <select name="place_limit" id="find_place_limit_edit" class="form-select"
                            style="width:100%"></select>

                        <small class="text-secondary">
                            {{ __('messages.management.modal.select_limit_hint_edit') }}
                        </small>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('messages.management.modal.btn_close') }}
                    </button>

                    <button type="submit" class="btn btn-success">
                        {{ __('messages.management.modal.btn_update_limit') }}
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
