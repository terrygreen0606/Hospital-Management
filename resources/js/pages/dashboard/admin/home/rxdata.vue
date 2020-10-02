<template>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h2 class="mb-0"> <i :class="$route.meta.titleIcon" class="text-primary page-title-icon"></i>{{ $route.meta.title }}</h2>
                                <p>{{ $route.meta.subtitle }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">NDC With Videos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Condition Videos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Admin Videos</a>
                                </li>
                                <!--<li class="nav-item">
                                    <a class="nav-link" id="tab4-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Med Videos and Mapping</a>
                                </li>-->
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1">
                                    <div class="table-responsive pmd-table-card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2>NDC With Videos</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <form
                                                    enctype="multipart/form-data"
                                                    novalidate
                                                    action="/data/import"
                                                    method="POST"
                                                        >
                                                    <div class="form-group">
                                                        <input
                                                            type="hidden"
                                                            name="table"
                                                            value="ndcUpload"
                                                        />
                                                        <input
                                                            type="file"
                                                            name="csv"
                                                            class="btn btn-info float-right ml-1"
                                                            style="height: 45px"
                                                        />
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary float-right">Import data</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-12">
                                                <table id="invoice-listing" class="table pmd-table">
                                                    <thead>
                                                        <tr>
                                                            <th>NDC9 Formatted</th>
                                                            <th>Name</th>
                                                            <th>Dosage Form Name</th>
                                                            <th>Video File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="row in ndcData.data" :key="row.id">
                                                            <td>{{ row.ncd9_formatted }}</td>
                                                            <td>{{ row.name }}</td>
                                                            <td>{{ row.dosage_form_name }}</td>
                                                            <td data-toggle="modal" data-target="#VideoModal">
                                                                <a href="#" @click="loadVideo(row.video)"><i class="ti-control-play menu-icon"></i> Play Video</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <td colspan="6" class="text-left pl-2">
                                                            <pagination
                                                                :limit="1"
                                                                :data="ndcData"
                                                                @pagination-change-page="getNDCVideos"
                                                            ></pagination>
                                                        </td>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="tab2" role="tabpanel" aria-labelledby="tab2">
                                    <div class="table-responsive pmd-table-card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2>Condition Videos</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <form
                                                    enctype="multipart/form-data"
                                                    novalidate
                                                    action="/data/import"
                                                    method="POST"
                                                        >
                                                    <div class="form-group">
                                                        <input
                                                            type="hidden"
                                                            name="table"
                                                            value="covUpload"
                                                        />
                                                        <input
                                                            type="file"
                                                            name="csv"
                                                            class="btn btn-info float-right ml-1"
                                                            style="height: 45px"
                                                        />
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary float-right">Import data</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table pmd-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Condition Video ID</th>
                                                            <th>Condition Video Title</th>
                                                            <th>Video File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="row in covData.data" :key="row.id">
                                                            <td>{{ row.condition_video_id }}</td>
                                                            <td>{{ row.condition_video_title }}</td>
                                                            <td data-toggle="modal" data-target="#VideoModal">
                                                                <a href="#" @click="loadVideo(row.video)"><i class="ti-control-play menu-icon"></i> Play Video</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <td colspan="6" class="text-left pl-2">
                                                            <pagination
                                                                :limit="1"
                                                                :data="covData"
                                                                @pagination-change-page="getConditionVideos"
                                                            ></pagination>
                                                        </td>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="tab3" role="tabpanel" aria-labelledby="tab3">
                                    <div class="table-responsive pmd-table-card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h2>Admin Videos</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <form
                                                    enctype="multipart/form-data"
                                                    novalidate
                                                    action="/data/import"
                                                    method="POST"
                                                        >
                                                    <div class="form-group">
                                                        <input
                                                            type="hidden"
                                                            name="table"
                                                            value="admUpload"
                                                        />
                                                        <input
                                                            type="file"
                                                            name="csv"
                                                            class="btn btn-info float-right ml-1"
                                                            style="height: 45px"
                                                        />
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-primary float-right">Import data</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table pmd-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Admin Video ID</th>
                                                            <th>Admin Video Title</th>
                                                            <th>Video File</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="row in advData.data" :key="row.id">
                                                            <td>{{ row.admin_video_id }}</td>
                                                            <td>{{ row.admin_video_title }}</td>
                                                            <td data-toggle="modal" data-target="#VideoModal">
                                                                <a href="#" @click="loadVideo(row.video)"><i class="ti-control-play menu-icon"></i> Play Video</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <td colspan="6" class="text-left pl-2">
                                                            <pagination
                                                                :limit="1"
                                                                :data="advData"
                                                                @pagination-change-page="getAdminVideos"
                                                            ></pagination>
                                                        </td>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="VideoModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-md" role="document">
                                    <div class="modal-content">
                                        <p data-dismiss="modal" class="closeButton">x</p>
                                        <div class="modal-body md-body">
                                            <p class="alignMe"><iframe id="vidSrc" src="" height="100%" width="80%"></iframe></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const STATUS_INITIAL = 0,
    STATUS_SAVING = 1,
    STATUS_SUCCESS = 2,
    STATUS_FAILED = 3;

    export default {
        mounted() {
            this.getNDCVideos();
            this.getConditionVideos();
            this.getAdminVideos();

            $('#VideoModal').on("hidden.bs.modal", () => {
                let addToSource = document.getElementById('vidSrc');
                addToSource.setAttribute('src', "")
            })
        },
        data () {
            return {
                ndcData: {},
                covData: {},
                advData: {},
                mvmData: {},
                uploadedNDCFiles: [],
                uploadError: null,
                currentStatus: null,
                uploadFieldName: "csv"
            };
        },
        computed: {
            isInitial() {
                return this.currentStatus === STATUS_INITIAL;
            },
            isSaving() {
                return this.currentStatus === STATUS_SAVING;
            },
            isSuccess() {
                return this.currentStatus === STATUS_SUCCESS;
            },
            isFailed() {
                return this.currentStatus === STATUS_FAILED;
            }
        },
        methods: {
            getNDCVideos(page = 1) {
                let p = page == 1 ? "" : "&page=" + page;
                this.axios
                    .get(`/api/patientEducation?type=ndc` + p)
                    .then(response => {
                        this.ndcData = response.data;
                    });
            },
            getConditionVideos(page = 1) {
                let p = page == 1 ? "" : "&page=" + page;
                this.axios
                    .get(`/api/patientEducation?type=cov` + p)
                    .then(response => {
                        this.covData = response.data;
                    });
            },
            getAdminVideos(page = 1) {
                let p = page == 1 ? "" : "&page=" + page;
                this.axios
                    .get(`/api/patientEducation?type=adv` + p)
                    .then(response => {
                        this.advData = response.data;
                    });
            },
            
            loadVideo(vid) {
                let addToSource = document.getElementById('vidSrc');
                addToSource.setAttribute('src', vid)
            }
        }

    }
</script>

<style scoped>
    .modal-md {
        width: 75%
    }
    .alignMe{
        text-align: center;
        height: 650px
    }
    .closeButton {
        text-align: right;
        margin-right: 5px;
        font-size: 21px;
        cursor: pointer;
    }
</style>
