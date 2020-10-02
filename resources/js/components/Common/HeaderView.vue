<template>
    <!-- <nav
        class="navbar col-lg-12 col-md-12 p-0 fixed-top d-flex flex-row"
        v-if="$auth.check()"
        >
        <div
            class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center"
        >
            <router-link
                class="navbar-brand brand-logo mr-5 text-center"
                to="/"
            >
                <img src="/assets/images/logo.png" class="mr-2" alt="logo" />
            </router-link>
            <router-link class="navbar-brand brand-logo-mini" to="/">
                <img src="/assets/images/favicon.png" alt="logo" />
            </router-link>
        </div>
        <div
            class="navbar-menu-wrapper d-flex align-items-center justify-content-between"
        >
            <ul class="navbar-nav mr-lg-2">
                <li class="nav-item nav-search d-none d-lg-block">
                    <div class="input-group">
                        <div
                            class="input-group-prepend hover-cursor"
                            id="navbar-search-icon"
                        >
                            <span class="input-group-text" id="search">
                                <i class="ti-search"></i>
                            </span>
                        </div>
                        <input
                            type="text"
                            class="form-control"
                            id="navbar-search-input"
                            placeholder="Search now"
                            aria-label="search"
                            aria-describedby="search"
                        />
                    </div>
                </li>
                <li class="nav-item nav-search d-lg-none align-left">
                    <h5>
                        {{ $auth.user().name }}
                    </h5>
                </li>
            </ul>

            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown mr-1" v-if="$auth.check()">
                    <div
                        class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                        aria-labelledby="messageDropdown"
                    >
                        <p
                            class="mb-0 font-weight-normal float-left dropdown-header"
                        >
                            Messages
                        </p>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img
                                    src="https://via.placeholder.com/36x36"
                                    alt="image"
                                    class="profile-pic"
                                />
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6
                                    class="preview-subject ellipsis font-weight-normal"
                                >
                                    David Grey
                                </h6>
                                <p
                                    class="font-weight-light small-text text-muted mb-0"
                                >
                                    The meeting is cancelled
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img
                                    src="https://via.placeholder.com/36x36"
                                    alt="image"
                                    class="profile-pic"
                                />
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6
                                    class="preview-subject ellipsis font-weight-normal"
                                >
                                    Tim Cook
                                </h6>
                                <p
                                    class="font-weight-light small-text text-muted mb-0"
                                >
                                    New product launch
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <img
                                    src="https://via.placeholder.com/36x36"
                                    alt="image"
                                    class="profile-pic"
                                />
                            </div>
                            <div class="preview-item-content flex-grow">
                                <h6
                                    class="preview-subject ellipsis font-weight-normal"
                                >
                                    Johnson
                                </h6>
                                <p
                                    class="font-weight-light small-text text-muted mb-0"
                                >
                                    Upcoming board meeting
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown" v-if="$auth.check()">
                    <div
                        class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                        aria-labelledby="notificationDropdown"
                    >
                        <p
                            class="mb-0 font-weight-normal float-left dropdown-header"
                        >
                            Notifications
                        </p>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-success">
                                    <i class="ti-info-alt mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">
                                    Application Error
                                </h6>
                                <p
                                    class="font-weight-light small-text mb-0 text-muted"
                                >
                                    Just now
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-warning">
                                    <i class="ti-settings mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">
                                    Settings
                                </h6>
                                <p
                                    class="font-weight-light small-text mb-0 text-muted"
                                >
                                    Private message
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-info">
                                    <i class="ti-user mx-0"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <h6 class="preview-subject font-weight-normal">
                                    New user registration
                                </h6>
                                <p
                                    class="font-weight-light small-text mb-0 text-muted"
                                >
                                    2 days ago
                                </p>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item nav-profile dropdown" v-if="$auth.check()">
                    <a
                        class="nav-link dropdown-toggle"
                        href="javascript:void(0)"
                        data-toggle="dropdown"
                        id="profileDropdown"
                    >
                        <i class="ti-angle-down text-primary pr-n1"></i>
                        <img
                            :src="$auth.user().avatar"
                            :alt="$auth.user().name"
                        />
                    </a>
                    <div
                        class="dropdown-menu dropdown-menu-right navbar-dropdown"
                        aria-labelledby="profileDropdown"
                    >
                        <router-link
                            class="dropdown-item"
                            to="/invoices"
                            v-if="$auth.user().role == 'patient'"
                        >
                            <i class="ti-files text-primary"></i>
                            <span class="menu-title">My Invoices</span>
                        </router-link>

                        <router-link
                            class="dropdown-item"
                            to="/payments"
                            v-if="$auth.user().role == 'patient'"
                        >
                            <i class="ti-credit-card text-primary"></i>
                            <span class="menu-title">My Payments</span>
                        </router-link>

                        <router-link
                            class="dropdown-item"
                            to="/patientEducation"
                            v-if="$auth.user().role == 'patient'"
                        >
                            <i class="ti-book text-primary"></i>
                            <span class="menu-title">Patient Education</span>
                        </router-link>

                        <router-link
                            class="dropdown-item"
                            :to="'/users/'+$auth.user().id+'/edit'"
                        >
                            <i class="ti-user text-primary"></i>
                            <span class="menu-title">Edit Profile</span>
                        </router-link>

                        <a
                            class="dropdown-item"
                            href="javascript:void(0)"
                            @click.prevent="$auth.logout()"
                             v-if="isMirror == 0"
                        >
                            <i class="ti-power-off text-primary"></i>
                            <span class="menu-title">Logout Now</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <div
            class="col-md-4 offset-md-4 infome"
            v-if="isMirror == 1"
            >
            <p class="mirrorText">You are currently mirroring an account</p>
            <button
                class="btn btn-sm btn-danger"
                @click="backToAdmin()">
                Leave
            </button>
        </div>
    </nav> -->
     <!-- BEGIN: Header-->
        <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
            <div class="navbar-wrapper">
                <div class="navbar-container content">
                    <div class="navbar-collapse d-flex justify-content-between" id="navbar-mobile">
                        <div class="float-left bookmark-wrapper d-flex align-items-center">
                            <ul class="nav navbar-nav">
                                <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0)"><i class="ficon bx bx-menu"></i></a></li>
                            </ul>
                            <!-- <ul class="nav navbar-nav bookmark-icons">
                                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon bx bx-envelope"></i></a></li>
                                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i></a></li>
                           </ul> -->
                        </div>

                        <router-link
                            class="header-logo-img align-items-center"
                            to="/"
                        >
                            <img src="/assets/images/logo.png" />
                        </router-link>

                        <ul class="nav navbar-nav">
                            <!-- <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="javascript:void(0)" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up">5</span></a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title">7 new Notification</span><span class="text-bold-400 cursor-pointer">Mark all as read</span></div>
                                    </li>
                                    <li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-left pr-0">
                                                    <div class="avatar mr-1 m-0"><img src="/app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="39" width="39"></div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">Congratulate Socrates Itumay</span> for work anniversaries</h6><small class="notification-text">Mar 15 12:32pm</small>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="d-flex justify-content-between read-notification cursor-pointer">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-left pr-0">
                                                    <div class="avatar mr-1 m-0"><img src="/app-assets/images/portrait/small/avatar-s-16.jpg" alt="avatar" height="39" width="39"></div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">New Message</span> received</h6><small class="notification-text">You have 18 unread messages</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between cursor-pointer">
                                            <div class="media d-flex align-items-center py-0">
                                                <div class="media-left pr-0"><img class="mr-1" src="/app-assets/images/icon/sketch-mac-icon.png" alt="avatar" height="39" width="39"></div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">Updates Available</span></h6><small class="notification-text">Sketch 50.2 is currently newly added</small>
                                                </div>
                                                <div class="media-right pl-0">
                                                    <div class="row border-left text-center">
                                                        <div class="col-12 px-50 py-75 border-bottom">
                                                            <h6 class="media-heading text-bold-500 mb-0">Update</h6>
                                                        </div>
                                                        <div class="col-12 px-50 py-75">
                                                            <h6 class="media-heading mb-0">Close</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between cursor-pointer">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-left pr-0">
                                                    <div class="avatar bg-primary bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content text-primary font-medium-2">LD</span></div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">New customer</span> is registered</h6><small class="notification-text">1 hrs ago</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cursor-pointer">
                                            <div class="media d-flex align-items-center justify-content-between">
                                                <div class="media-left pr-0">
                                                    <div class="media-body">
                                                        <h6 class="media-heading">New Offers</h6>
                                                    </div>
                                                </div>
                                                <div class="media-right">
                                                    <div class="custom-control custom-switch">
                                                        <input class="custom-control-input" type="checkbox" checked id="notificationSwtich">
                                                        <label class="custom-control-label" for="notificationSwtich"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between cursor-pointer">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-left pr-0">
                                                    <div class="avatar bg-danger bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content"><i class="bx bxs-heart text-danger"></i></span></div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">Application</span> has been approved</h6><small class="notification-text">6 hrs ago</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between read-notification cursor-pointer">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-left pr-0">
                                                    <div class="avatar mr-1 m-0"><img src="/app-assets/images/portrait/small/avatar-s-4.jpg" alt="avatar" height="39" width="39"></div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">New file</span> has been uploaded</h6><small class="notification-text">4 hrs ago</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between cursor-pointer">
                                            <div class="media d-flex align-items-center">
                                                <div class="media-left pr-0">
                                                    <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                        <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">Finance report</span> has been generated</h6><small class="notification-text">25 hrs ago</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between cursor-pointer">
                                            <div class="media d-flex align-items-center border-0">
                                                <div class="media-left pr-0">
                                                    <div class="avatar mr-1 m-0">
                                                        <img
                                                            :src="$auth.user().avatar"
                                                            :alt="$auth.user().name"
                                                            height="39"
                                                            width="39"
                                                        />
                                                        </div>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading"><span class="text-bold-500">New customer</span> comment recieved</h6><small class="notification-text">2 days ago</small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a></li>
                                </ul>
                            </li> -->
                            <li class="dropdown dropdown-user nav-item">
                                <a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0)" @click="userOption()">
                                    <div class="user-nav d-sm-flex d-none">
                                        <span class="user-name">{{this.$auth.user().name}}</span>
                                    </div>
                                    <span>
                                        <img
                                            :src="$auth.user().avatar"
                                            :alt="$auth.user().name"
                                            height="40"
                                            width="40"
                                        />
                                    </span>
                                </a>
                                <div class="dropdown dropdown-menu dropdown-menu-right pb-0" :class="{ 'show': showProfile }">
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="bx bx-user mr-50"></i> Edit Profile</a>
                                    <!-- <a class="dropdown-item" href="javascript:void(0)"><i class="bx bx-envelope mr-50"></i> My Inbox</a> -->
                                    <!-- <a class="dropdown-item" href="javascript:void(0)"><i class="bx bx-check-square mr-50"></i> Task</a> -->
                                    <!-- <a class="dropdown-item" href="javascript:void(0)"><i class="bx bx-message mr-50"></i> Chats</a> -->
                                    <div class="dropdown-divider mb-0"></div>
                                    <a class="dropdown-item" @click.prevent="$auth.logout()" href="javascript:void(0)"><i class="bx bx-power-off mr-50"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    <!-- END: Header-->
</template>
<script>
export default {
    data() {
        return {
            isMirror: 0,
            showProfile: false
        };
    },
    mounted() {
        let mirror = localStorage.getItem('mirrorView');
        this.isMirror = mirror ? mirror : 0;
    },
    created() {
        this.axios.get(`/api/auth/refresh`).then(response => {
            if (response.data.logout) {
                this.$auth.logout();
            }
        });
    },
    methods: {
        backToAdmin() {
            
            let data = {
                id : localStorage.getItem('admin_id')
            }
            this.axios.post(`/api/mirrorLogin`, data).then(response => {
                if(response.data.status == 'success'){
                    localStorage.setItem('mirrorView', 0) 
                    this.$router.push({ name: "allusers" })
                    location.reload();
                }

            });
        },

        userOption()
        {
            this.showProfile = !this.showProfile;
        }
    }
};
</script>

<style scoped>
    .infome {
        background-color: yellow;
        width: 100%;
        text-align: center !important;
    }
    .mirrorText {
        display: inline-block;
    }
</style>
