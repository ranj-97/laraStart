<style>
.widget-user-header {
    background-position: center;
    background-size: cover;
}
</style>

<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3 ">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div
                        class="widget-user-header text-white"
                        style="background: url(https://adminlte.io/themes/dev/AdminLTE/dist/img/photo1.png) center center;"
                    >
                        <h3 class="widget-user-username text-left">
                            Elizabeth Pierce
                        </h3>
                        <h5 class="widget-user-desc text-left">Web Designer</h5>
                    </div>
                    <div class="widget-user-image">
                        <img
                            class="img-circle"
                            :src="getProfilePhoto()"
                            alt="User Avatar"
                        />
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">3,200</h5>
                                    <span class="description-text">SALES</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">13,000</h5>
                                    <span class="description-text"
                                        >FOLLOWERS</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">35</h5>
                                    <span class="description-text"
                                        >PRODUCTS</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    href="#activity"
                                    data-toggle="tab"
                                    >Activity</a
                                >
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    href="#settings"
                                    data-toggle="tab"
                                    >Settings</a
                                >
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="activity">
                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block"></div>
                                </div>
                                <!-- Post -->
                                <div><h1>hello</h1></div>
                                <!-- /.post -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group row">
                                        <label
                                            for="inputName"
                                            class="col-sm-2 col-form-label"
                                            >Name</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                v-model="form.name"
                                                class="form-control"
                                                id="inputName"
                                                placeholder="Name"
                                                 :class="{
                                        'is-invalid': form.errors.has(
                                            'name'
                                        )
                                    }"
                                            />
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputEmail"
                                            class="col-sm-2 col-form-label"
                                            >Email</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="email"
                                                v-model="form.email"
                                                class="form-control"
                                                id="inputEmail"
                                                placeholder="Email"
                                                 :class="{
                                        'is-invalid': form.errors.has(
                                            'email'
                                        )
                                    }"
                                            />
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            for="inputExperience"
                                            class="col-sm-2 col-form-label"
                                            >Experience</label
                                        >
                                        <div class="col-sm-10">
                                            <textarea
                                                v-model="form.bio"
                                                class="form-control"
                                                id="inputExperience"
                                                placeholder="Experience"
                                            ></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            for="photo"
                                            class="col-sm-2 col-form-label"
                                            >Profile Photo</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="file"
                                                @change="photoBase64"
                                                class="form-control-file"
                                                id="photo"
                                                placeholder="Photo"
                                                 :class="{
                                        'is-invalid': form.errors.has(
                                            'photo'
                                        )
                                    }"
                                            />
                                            <has-error :form="form" field="photo"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label
                                            for="password"
                                            class="col-sm-2 col-form-label"
                                            >Password</label
                                        >
                                        
                                        <div class="col-sm-10">
                                            <input
                                                v-model="form.password"
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                placeholder="Password"
                                                 :class="{
                                        'is-invalid': form.errors.has(
                                            'password'
                                        )
                                    }"
                                            />
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button
                                                type="submit"
                                                @click.prevent="updateInfo"
                                                class="btn btn-success"
                                            >
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: new Form({
                id: "",
                name: "",
                email: "",
                password: "",
                type: "",
                bio: "",
                photo: ""
            })
        };
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
      getProfilePhoto(){
        let photo=(this.form.photo.length >100)? this.form.photo:"img/profile/"+ this.form.photo;

          return photo;
      },
        updateInfo() {
                      this.$Progress.start();
            this.form
                .put("/api/profile")
                .then(() => {
                  Fire.$emit("AfetrEvent");
                  toast.fire({
                        icon: "success",
                        title: "Info Updated successfully"
                    });
                   this.$Progress.finish();
                })
                .catch(() => {
                   this.$Progress.fail();
                });
        },
        photoBase64(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            if (file["size"] < 3111775) {
                reader.onloadend = file => {
                    this.form.photo = reader.result;
                };
                reader.readAsDataURL(file);
            } else {
                swal.fire(
                    "error!",
                    "you are uploading large image.",
                    "warning"
                );
            }
        }
    },
    created() {
        axios.get("api/profile").then(({ data }) => this.form.fill(data));
         Fire.$on("AfetrEvent", () => {
            axios.get("api/profile").then(({ data }) => this.form.fill(data));
        });
    }
};
</script>
