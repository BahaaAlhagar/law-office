<template>
    <form :action="url" method="post" class="dropzone" enctype="multipart/form-data" :id="id" >
        <input type="hidden" id="csrf-token" name="_token" :value="csrfToken">
        <div class="dz-message" data-dz-message><span>اضغط هنا او اسحب الملفات للرفع</span></div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                id: 'myDropzone',
                url: window.location.pathname,
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
            };
        },
        mounted () {
            let Dropzone = require('dropzone');
            let element = document.getElementById(this.id);
            this.dropzone = new Dropzone(element, {
                acceptedFiles: '.jpg, .jpeg, .jpe, .png, .gif, .bmp, .doc, .docx, .dot, .word, .pdf, .xls, .ppt, .rar, .zip, .txt',
                paramName: 'file',
                headers: {
                  'X-CSRFToken': $('meta[name="token"]').attr('content')
                },
                dictResponseError: 'خطأ فى رفع الملف!',
                addRemoveLinks: true
            });

            // Handle the dropzone events
            let vm = this;

            this.dropzone.on('thumbnail', function (file, dataUrl) {
                vm.$emit('vdropzone-thumbnail', file, dataUrl)
            });

            this.dropzone.on('addedfiles', function (files) {
                vm.$emit('vdropzone-files-added', files)
            });

            this.dropzone.on('removedfile', function (file) {
                vm.$emit('vdropzone-removed-file', file)
            });

            this.dropzone.on('success', function (file, response) {
                vm.$emit('vdropzone-success', file, response)
            });

            this.dropzone.on('successmultiple', function (file, response) {
                vm.$emit('vdropzone-success-multiple', file, response)
            });

            this.dropzone.on('error', function (file, error, xhr) {
                vm.$emit('vdropzone-error', file, error, xhr)
            });

            this.dropzone.on('sending', function (file, xhr, formData) {
                vm.$emit('vdropzone-sending', file, xhr, formData)
            });

            this.dropzone.on('sendingmultiple', function (file, xhr, formData) {
                vm.$emit('vdropzone-sending-multiple', file, xhr, formData)
            });

            this.dropzone.on('queuecomplete', function (file, xhr, formData) {
                vm.$emit('vdropzone-queue-complete', file, xhr, formData)
            });

            this.dropzone.on('drop', function (event) {
                vm.$emit('vdropzone-drop', event)
            });

            this.dropzone.on('dragstart', function (event) {
                vm.$emit('vdropzone-drag-start', event)
            });

            this.dropzone.on('dragend', function (event) {
                vm.$emit('vdropzone-drag-end', event)
            });

            this.dropzone.on('dragenter', function (event) {
                vm.$emit('vdropzone-drag-enter', event)
            });

            this.dropzone.on('dragover', function (event) {
                vm.$emit('vdropzone-drag-over', event)
            });

            this.dropzone.on('dragleave', function (event) {
                vm.$emit('vdropzone-drag-leave', event)
            });

            vm.$emit('vdropzone-mounted');
        }
    }
</script>

<style scoped>
    @import url('~dropzone/dist/dropzone.css');
</style>
