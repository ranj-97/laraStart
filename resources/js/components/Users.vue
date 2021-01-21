<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users Table</h3>

            <div class="card-tools">
                <button class="btn btn-success"
                data-toggle="modal"
                 data-target="#Add-User"
                            >Add New
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
                <tr v-for="user in users" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.type}}</td>
                  <td>{{user.created_at | moment("dddd, MMMM Do YYYY")}}</td>

                  <td>
                      <a href="#">
                      <i class="fa fa-user-edit fa-2x blue"></i>
                      </a>
                      
                       <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash-alt fa-2x red"></i>
                      </a>
                  </td>
                </tr>
               
               
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    
<!-- Modal -->
<div class="modal fade" id="Add-User" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
                  <form @submit.prevent="createUser">

      <div class="modal-body">
        <!-- body of modal -->
                <div class="form-group">
                        <input v-model="form.name" type="text" name="name" placeholder="name"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                             <has-error :form="form" field="name"></has-error>
                              </div>
               <div class="form-group">
                      <input v-model="form.email" type="email" name="email" placeholder="Email Address"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                             <has-error :form="form" field="email"></has-error>
                              </div>
                <div class="form-group">
                        <input v-model="form.password" type="password" name="password" placeholder="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                             </div>
                 <div class="form-group">
                      <textarea v-model="form.bio" type="text" name="bio" placeholder="Short Bio for User (optional)"
                              class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                             <has-error :form="form" field="bio"></has-error>
                              </div>
                <div class="form-group">
                      <select v-model="form.type" type="text" name="type" 
                              class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                              <option value="">Select User Role</option>
                              <option value="admin">Admin</option>
                              <option value="user">Standart User</option>
                              <option value="auther">Author</option>
                              </select>
                             <has-error :form="form" field="type"></has-error>
                              </div>
             </div>

      <div class="modal-footer ">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
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
        users:{},
        
      form: new Form({
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: "",
      }),
    };
  },
    methods: {
        deleteUser(id){
                swal.fire({
                width:300,
                 showCancelButton: true,
                 confirmButtonColor: '#d33',
                 cancelButtonColor: '#3085d6',
                confirmButtonText: 'delete'
                }).then((result) => {
                    // send request to server to delete 
                    this.form.delete('api/user'+id).then(()=>{
                      if (result.isConfirmed) {
                         swal.fire(
                         'Deleted!',
                         'Your file has been deleted.',
                         'success'
                           )
                          }
                    }).catch(()=>{
                        swal.fire(
                         'failed!',
                         'There was somthing wrong.',
                         'warning'
                           )
                    })
                
                        })
                        },
        loadUser(){
            axios.get('/api/user').then(({data})=>(this.users = data.data));
        }
        ,
        createUser () {
        
          this.$Progress.start()
          // Submit the form via a POST request
          this.form.post('api/user')
          .then(()=>{
                Fire.$emit('AfetrCreate')
                $('#Add-User').modal('hide')
                 toast.fire({
                  icon: 'success',
                 title: 'User Created successfully'
                       });
          })
          .catch(()=>{
            this.$Progress.fail()
          })
         
          
        }
      },
  created() {
      this.loadUser();
      Fire.$on('AfetrCreate',()=>{this.loadUser();});
    //   setInterval(()=>{this.loadUser();} ,1000);
  },
};
</script>
