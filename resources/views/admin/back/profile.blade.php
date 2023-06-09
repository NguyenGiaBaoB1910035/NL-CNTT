@extends('admin.template.master')

@section('title', 'Profile | Admin - Benjamin Shop')

@section('heading', '')

@section('des_heading', '')

@section('x_heading', 'Thông tin profile')

@section('content')
    <style>
        #content_history {
            white-space: break-spaces;
        }

    </style>
    <div class="x_content">

        <div class="col-md-3 col-sm-3  profile_left">
            <div class="profile_img">
                <div id="crop-avatar ">
                    <!-- Current avatar -->
                    <img class="img-responsive avatar-view img-fluid border-secondary border-2 rounded"
                        src="{{ asset('images/avatar/' . $info->avatar) }}" alt="Avatar" title="Change the avatar">
                </div>
            </div>
            <h3>{{ $info->fullname }}</h3>

            <ul class="list-unstyled user_data">
                <li>
                    <i class="mr-2 fas fa-map-marker-alt"></i> {{ $info->address }}
                </li>
                <li>
                    @if ($info->gender == 'Nam')
                        <i class="mr-2 fas fa-mars"></i>
                    @else
                        <i class="mr-2 fas fa-venus"></i>
                    @endif

                    {{ $info->gender }}
                </li>
                <li>
                    <i class="mr-2 fas fa-cake"></i> {{ date('d/m/Y', strtotime(Auth::user()->birthday)) }}
                </li>
                <li>
                    <i class="mr-2 fas fa-phone"></i> {{ $info->phone }}
                </li>
                <li>
                    <i class="mr-2 far fa-envelope"></i> {{ $info->email }}
                </li>
            </ul>

            @if ($info->id == Auth::id())
                <a class="btn btn-success text-light" data-bs-toggle="modal" data-bs-target="#editProfile">
                    <i class="fa fa-edit m-right-xs"></i>Edit Profile
                </a>
            @endif

            <br />

        </div>
        <div class="col-md-9 col-sm-9 ">
            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab"
                            data-toggle="tab" aria-expanded="true">Lịch sử làm việc</a>
                    </li>
                    <li role="presentation" class="active"><a href="#tab_content2" role="tab" id="profile-tab"
                            data-toggle="tab" aria-expanded="false">Đơn hàng đã duyệt</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">

                        <!-- start recent activity -->
                        <ul class="messages">
                            @if (count($history) < 1)
                                <p class="text-center fs-5 fw-bold text-primary">Lịch sử trống</p>
                            @endif
                            @foreach ($history->reverse() as $v)
                                <li class="border-0 border-dark boder-bottom">
                                    <img src="{{ asset('images/avatar') }}/{{ $info->avatar }}"
                                        class="avatar rounded-circle" alt="Avatar">
                                    <div class="message_date text-center">
                                        <h3 class="date text-info">{{ date('d', $v->create_at) }}</h3>
                                        <p class="month">{{ date('M', $v->create_at) }}</p>
                                    </div>
                                    <div class="message_wrapper" id="message_wrapper">
                                        <h4 class="heading">{{ $v->title }}</h4>
                                        <details>
                                            <summary>Xem chi tiết</summary>
                                            <p class="text-dark" id="content_history">{{ $v->content }}</p>
                                        </details>

                                        <p class="url ps-3 text-secondary">
                                            <i class="far fa-clock"></i>
                                            {{ date('h:m:s d-m-Y', $v->create_at) }}
                                        </p>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                        <!-- end recent activity -->

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <table class="data table table-striped no-margin">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên Khách Hàng</th>
                                    <th>Phương Thức Thành Toán</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($order) < 1)
                                    <tr>
                                        <td class="fw-bold fs-6 text-center" colspan="5">
                                            Chưa duyệt đơn hàng nào
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($order as $k => $v)
                                    <tr>
                                        <td>{{ $k + 1 }}</td>
                                        <td>{{ $v->fullname }}</td>
                                        <td>{{ $v->payment_method }}</td>
                                        <td>{{ number_format($v->total) }} VNĐ</td>
                                        <td class="vertical-align-mid">
                                            {{ $v->status }}
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready({
            var hMessage = message_wrapper
            if (hMessage > 200) {
                message_wrapper.hMessage(200)

            }
        });
    </script>

    <!-- Modal Edit Profile-->
    <div class="modal fade " id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 100vh">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b> Sửa thông tin cá nhân </b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="modal_editProductType">
                    <form action="{{ route('admin.profile.edit') }}" id="frmEditProfile" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        <div class="row justify-content-center">
                            <input type="hidden" name="id" value="{{ Auth::id() }}">
                            <div class="col-6">
                                <div class="card">
                                    <img src="{{ asset('images/avatar/' . Auth::user()->avatar) }}"
                                        class="card-img-top" id="avatar-img" alt="">
                                    <div class="card-body text-center">
                                        <label for="avatar" class="m-0">
                                            <a class="btn btn-light border m-0"><i class="fa fa-camera"></i> Chọn ảnh
                                                mới</a>
                                        </label>
                                        <input type="file" class="d-none" name="avatar" id="avatar"
                                            onchange="readImg(this);" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fullname" class="form-label">Họ tên:</label>
                            <input type="text" id="fullname" name="fullname" value="{{ Auth::user()->fullname }}"
                                class="form-control" placeholder="Nhập họ tên" required>
                        </div>
                        <div class="form-group">
                            <label for="address" class="form-label">Địa chỉ:</label>
                            <input type="text" id="address" name="address" value="{{ Auth::user()->address }}"
                                class="form-control" placeholder="Nhập địa chỉ" required>
                        </div>
                        <div class="form-group">
                            <label for="gender" class="form-label">Giới tính:</label>
                            <div class="row">
                                <div class="col-2">
                                    <input type="radio" @if (Auth::user()->gender == 'Nam') checked @endif id="gender-male"
                                        name="gender" value="Nam" required>
                                    <label for="gender-male">Nam</label>
                                </div>
                                <div class="col-2">
                                    <input type="radio" @if (Auth::user()->gender != 'Nam') checked @endif id="gender-female"
                                        name="gender" value="Nữ" required>
                                    <label for="gender-female">Nữ</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthday" class="form-label">Ngày sinh:</label>
                            <input type="date" id="birthday" name="birthday" value="{{ date('Y-m-d', strtotime(Auth::user()->birthday)) }}"
                                class="form-control" required>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit" form="frmEditProfile">Lưu</button>
                    <button class="btn btn-success" type="reset" onclick="resetfrm('{{ Auth::user()->avatar }}')"
                        form="frmEditProfile">Reset</button>
                </div>
                <script>
                    function rangePercent(percent) {
                        $('#percent_input').innerHTML = percent.value + "%";
                    }

                    function percent_input(input) {
                        $('#percent').value = input.value
                    }

                    function readImg(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('#avatar-img').attr('src', e.target.result);
                            };

                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    function resetfrm(img) {
                        $('#avatar-img').attr('src', '/images/avatar/' + img);
                    }
                </script>
            </div>
        </div>
    </div>
@stop
