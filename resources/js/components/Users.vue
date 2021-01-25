<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Add New
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Registerd At</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ toUpperCase(user.name) }} </td>
                                    <td>{{ toUpperCase(user.email) }}</td>
                                    <td>{{ toUpperCase(user.type) }}</td>
                                    <td>
                                        {{
                                            user.created_at
                                                | moment("dddd, MMMM Do YYYY")
                                        }}
                                    </td>

                                    <td>
                                        <a href="#" @click="editModal(user)">
                                            <i
                                                class="fa fa-user-edit fa-2x blue"
                                            ></i>
                                        </a>

                                        <a
                                            href="#"
                                            @click="deleteUser(user.id)"
                                        >
                                            <i
                                                class="fa fa-trash-alt fa-2x red"
                                            ></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="users" :limit='2' :show-disabled="true" @pagination-change-page="getResults">
                            <span slot="prev-nav">&lt; Previous</span>
	<span slot="next-nav">Next &gt;</span>
                        </pagination>

                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div
            class="modal fade"
            id="Add-User"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            v-show="editMode"
                            class="modal-title"
                            id="exampleModalLongTitle"
                        >
                            Update User
                        </h5>
                        <h5
                            v-show="!editMode"
                            class="modal-title"
                            id="exampleModalLongTitle"
                        >
                            Add New User
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        @submit.prevent="editMode ? updateUser() : createUser()"
                    >
                        <div class="modal-body">
                            <!-- body of modal -->
                            <div class="form-group">
                                <input
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    placeholder="name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <input
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    placeholder="Email Address"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('email')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="email"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <input
                                    v-model="form.password"
                                    type="password"
                                    name="password"
                                    placeholder="password"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'password'
                                        )
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="password"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <textarea
                                    v-model="form.bio"
                                    type="text"
                                    name="bio"
                                    placeholder="Short Bio for User (optional)"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('bio')
                                    }"
                                ></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>
                            <div class="form-group">
                                <select
                                    v-model="form.type"
                                    type="text"
                                    name="type"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('type')
                                    }"
                                >
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standart User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="type"
                                ></has-error>
                            </div>
                        </div>

                        <div class="modal-footer ">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                v-show="editMode"
                                type="submit"
                                class="btn btn-success"
                            >
                                Update
                            </button>
                            <button
                                v-show="!editMode"
                                type="submit"
                                class="btn btn-primary"
                            >
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            editMode: false,
            users: {},

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
    methods: {
        getResults(page = 1) {
			axios.get('api/user?page=' + page)
				.then(response => {
					this.users = response.data;
                });
                },
      toUpperCase(data){
        return data.charAt(0).toUpperCase() + data.slice(1)
      },
        updateUser() {
            this.$Progress.start();
            
                this.form.put("/api/user/"+this.form.id)
                .then(() => {
                    $("#Add-User").modal("hide");
                   
                    toast.fire({
                        icon: "success",
                        title: "Information has been updated"
                    });
                    this.$Progress.finish();
                    Fire.$emit("AfetrEvent");
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        },
        editModal(user) {
            this.editMode = true;
            this.form.reset();
            $("#Add-User").modal("show");
            this.form.fill(user);
        },
        newModal() {
            this.editMode = false;
            this.form.reset();
            $("#Add-User").modal("show");
        },
        deleteUser(id) {
            swal.fire({
                width: 300,
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "delete"
            }).then(result => {
              if (result.isConfirmed) {
                // send request to server to delete
                axios
                    .delete("api/user/" + id)
                    .then(() => {
                        
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("AfetrEvent");
                       
                    })
                    .catch(() => {
                        swal.fire(
                            "failed!",
                            "There was somthing wrong.",
                            "warning"
                        );
                    }); }
            });
        },
        loadUser() {
            if (this.$gate.isAdminOrAuthor()) {
            // axios.get("/api/user").then(({ data }) => (this.users = data.data)); its make array
                        axios.get("/api/user").then(({ data }) => (this.users = data));

            }
        },
        createUser() {
            this.$Progress.start();
            // Submit the form via a POST request
            this.form
                .post("api/user")
                .then(() => {
                    Fire.$emit("AfetrEvent");
                    $("#Add-User").modal("hide");
                    toast.fire({
                        icon: "success",
                        title: "User Created successfully"
                    });
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        }
    },
    created() {

 Fire.$on("searching", () => {
            let query=this.$parent.search;
            axios.get('api/findUser?q='+query)
            .then((data)=>{
                    this.users=data.data;
            }).catch(()=>{

            })
            
        });
        
        this.loadUser();
        Fire.$on("AfetrEvent", () => {
            this.loadUser();
        });
        //   setInterval(()=>{this.loadUser();} ,1000);
    }
};
</script>
