<template>
    <div class="modal">{{ body }}</div>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            body: ''};
    },

    created(){
        // Events.listenFor('modalShow', ( data ) => {
        //     this.title = data.title;
        //     this.body = data.message;
        //     this.showModal();
        // });
    },

    methods: {
        showModal () {
          this.$refs.myModalRef.show()
        }
        /* This not needed for this example
        ,
        hideModal () {
          this.$refs.myModalRef.hide()
        }
        */
    }
}
</script>