<template>
    <div class="container-scroller">
        <header-view v-if="$auth.check()" class="border-bottom"></header-view>
        <div class="container-fluid page-body-wrapper px-0">
            <sidebar-view v-if="$auth.check()"></sidebar-view>
            
	        <div class="content-wrapper d-flex align-items-center auth" v-else>
                <router-view></router-view>
            </div>
        </div>
        <div class="main-panel" v-if="$auth.check()">
            <div class="app-content content mt-5 pt-3 px-3">

                <h2><i class="float-left text-primary page-title-icon" :class="$route.meta.titleIcon"></i>{{ $route.meta.title }}</h2>
                <hr>

                <router-view></router-view>
            </div>

            <footer-view class="border-top footer-custom-wrapper"></footer-view>
            
        </div>
    </div>
</template>
<style type="text/css">
    .page-title-icon {
        font-size: 35px; 
        margin-right: 5px;
    }

    .footer-custom-wrapper {
        position: fixed; 
        bottom: 0px; 
        right: 0px;
        left: 0px; 
        background: rgb(242, 244, 244) !important;
    }
</style>
<script>
    export default {}
</script>