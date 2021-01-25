<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
               <not-found></not-found>
            </div>
        </div>
    </div>
</template>

<script>
import notFoundPage from './notFoundPage.vue'
    export default {
  components: { notFoundPage },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
