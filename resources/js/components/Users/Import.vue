<template>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Import Users</h4>
            <div class="row">
                <div class="col-md-12">
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
                                value="users"
                            />
                            <div class="dropbox">
                                <input
                                    type="file"
                                    name="csv"
                                    class="input-file"
                                />
                                <p v-if="isInitial">
                                    Drag your file here to begin<br />
                                    or click to browse
                                </p>
                                <p v-if="isSaving">
                                    Uploading {{ fileCount }} files...
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary">Import data</button>
                        </div>
                    </form>
                    <form
                        enctype="multipart/form-data"
                        novalidate
                        v-if="isInitial || isSaving"
                        class="d-none"
                    >
                        <div class="form-group">
                            <input
                                type="hidden"
                                name="table"
                                value="users"
                            />
                            <div class="dropbox">
                                <input
                                    type="file"
                                    multiple
                                    :name="uploadFieldName"
                                    :disabled="isSaving"
                                    @change="
                                        filesChange(
                                            $event.target.name,
                                            $event.target.files
                                        );
                                        fileCount = $event.target.files.length;
                                    "
                                    class="input-file"
                                />
                                <p v-if="isInitial">
                                    Drag your file here to begin<br />
                                    or click to browse
                                </p>
                                <p v-if="isSaving">
                                    Uploading {{ fileCount }} files...
                                </p>
                            </div>
                        </div>
                    </form>
                    <!--SUCCESS-->
                    <div class="alert alert-success" v-if="isSuccess">
                        <h5>
                            Uploaded {{ uploadedFiles.length }} file(s)
                            successfully.
                        </h5>
                        <p>
                            <a href="javascript:void(0)" @click="reset()"
                                >Upload again</a
                            >
                        </p>
                        <ul class="list-unstyled">
                            <li v-for="item in uploadedFiles" v-bind:key="item">
                                <img
                                    :src="item.url"
                                    class="img-responsive img-thumbnail"
                                    :alt="item.originalName"
                                />
                            </li>
                        </ul>
                    </div>
                    <!--FAILED-->
                    <div class="alert alert-danger" v-if="isFailed">
                        <h5>Upload failed.</h5>
                        <p>
                            <a href="javascript:void(0)" @click="reset()"
                                >Try again</a
                            >
                        </p>
                        <pre>{{ uploadError }}</pre>
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
    name: "app",
    data() {
        return {
            uploadedFiles: [],
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
        reset() {
            // reset form to initial state
            this.currentStatus = STATUS_INITIAL;
            this.uploadedFiles = [];
            this.uploadError = null;
        },
        save(formData) {
            // upload data to the server
            this.currentStatus = STATUS_SAVING;

            const url = `/data/import`;
            this.axios.post(url, formData)
                .then(x => {
                    this.uploadedFiles = [].concat(x.data);
                    this.currentStatus = STATUS_SUCCESS;
                })
                .catch(err => {
                    this.uploadError = err.response;
                    this.currentStatus = STATUS_FAILED;
                });
        },
        filesChange(fieldName, fileList) {
            // handle file changes
            const formData = new FormData();

            if (!fileList.length) return;

            // append the files to FormData
            Array.from(Array(fileList.length).keys()).map(x => {
                formData.append(fieldName, fileList[x], fileList[x].name);
            });

            // save it
            this.save(formData);
        },
    
    },
    mounted() {
        this.reset();
    }
};
</script>

<style lang="scss">
.dropbox {
    outline: 2px dashed grey; /* the dash box */
    outline-offset: -10px;
    background: #ededed;
    color: dimgray;
    padding: 10px 10px;
    min-height: 200px; /* minimum height */
    position: relative;
    cursor: pointer;
}

.input-file {
    opacity: 0; /* invisible but it's there! */
    width: 100%;
    height: 200px;
    position: absolute;
    cursor: pointer;
}

.dropbox:hover {
    background: #2da6a2; /* when mouse over to the drop zone, change color */
}

.dropbox p {
    font-size: 1.2em;
    text-align: center;
    padding: 50px 0;
}
</style>
