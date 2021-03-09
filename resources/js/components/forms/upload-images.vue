<template>
    <div class="images-upload">
        <vue-upload-multiple-image
            @upload-success="uploadImageSuccess"
            @before-remove="beforeRemove"
            @edit-image="editImage"
            @data-change="dataChange"
            dragText="Arrastrar y soltar aquí las imágenes"
            :browseText="
				limit > 1 ? 'Seleccionar las imágenes' : 'Seleccionar la imágen'
			"
            primaryText="Seleccione"
            markIsPrimaryText="Establecer Foto Principal"
            popupText="Esta imagen se mostrará por defecto"
            dropText="Suelta tu archivo aquí ..."
            accept="image/gif, image/jpeg, image/png, image/bmp, image/jpg, image/svg"
            :multiple="limit > 1"
            :showPrimary="true"
            :maxImage="limit"
            :data-images="miniatureImages"
        ></vue-upload-multiple-image>
    </div>
</template>

<script>
import VueUploadMultipleImage from "vue-upload-multiple-image";
import resizeImage from "../../utils";
export default {
    props: {
        limit: {
            type: Number,
            default: 5,
        },
        editImages: {
            type: Array,
            default: []
        }
    },
    data: function () {
        return {
            images: [],
            miniatureImages: [],
        };
    },

    components: {
        VueUploadMultipleImage,
    },

    async mounted() {
        if(this.editImages.length > 0){
            await this.editImages.forEach(image => {
                resizeImage(image, 1200, 1400).then((result) => {
                    this.miniatureImages.push({
                        default: 1,
                        highlight: 1,
                        name: new Date().getTime(),
                        path: result,
                    })
                });
            })
        }
    },
    computed: {},
    watch: {},
    methods: {
        async updateFileList(fileList) {
            this.$emit("on-upload-images", await this.parserImages(fileList));
        },

        async parserImages(data) {
            if (!data) return [];
            const values = Object.values(data);
            this.images = [];
            values.forEach((element) => {
                this.images.push({
                    name: new Date().getTime(),
                    extension: "data:image/png;base64",
                    mime_type: "data:image/png;base64",
                    binary: element.path,
                });
            });
            return this.images;
        },

        async uploadImageSuccess(formData, index, fileList) {
            await resizeImage(fileList[index].path, 1200, 1400).then((result) => {
                fileList[index].path = result
            });

            this.miniatureImages.push(fileList[index])
            await this.updateFileList(fileList);
        },
        async beforeRemove(index, done, fileList) {
            var r = confirm(
                "¿Estás seguro de que quieres eliminar este elemento?"
            );
            if (r == true) {
                done();
                await this.updateFileList(fileList);
            }
        },

        async editImage(formData, index, fileList) {
            await this.updateFileList(fileList);
        },

        dataChange(data) {},
        limitExceeded(amount) {},
    },
};
</script>
