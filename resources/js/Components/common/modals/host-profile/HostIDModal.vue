<template>
  <div
    class="modal fade p-4 p-md-0 image-modal"
    id="image-modal"
    tabindex="-1"
    aria-labelledby="imageCropperModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-xl modal-dialog-centered image-modal">
      <div class="modal-content modal-content-radius d-none d-md-block id-background">
        <button
          type="button"
          class="btn-close close-btn-outside"
          @click="closeImageModal"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Close"
        ></button>
        <div class="modal-body">
          <h6 class="ps-1">{{ selectedIdSide }}</h6>
          <div class="cropper-container text-center">
            <img
              :src="modalImageSrc"
              alt=""
              class="img-fluid image-content-radius border border-4"
              data-toggle="tooltip"
              data-placement="bottom"
              title=""
            />
          </div>
        </div>
      </div>

      <div class="modal-content modal-content-radius-mobile d-block d-md-none id-background">
        <button
          type="button"
          class="btn-close close-btn-outside-mobile text-dark"
          @click="closeImageModal"
          data-toggle="tooltip"
          data-placement="bottom"
          title="Close"
        ></button>
        <div class="modal-body-mobile">
          <div class="cropper-container text-center">
            <img
              :src="modalImageSrc"
              alt=""
              class="img-fluid image-content-radius-mobile"
              data-toggle="tooltip"
              data-placement="bottom"
              title=""
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  selectedIdSide: { type: String, required: true },
  modalImageSrc: { type: String, required: true },
})

const closeImageModal = () => {
  $('#image-modal').modal('hide')
}
</script>

<style scoped>
.cropper-container {
  display: flex;
  justify-content: center;
  align-items: center;
  max-width: 100%;
  height: 500px;
  overflow: hidden;
}

.image-content-radius,
.image-content-radius-mobile {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
  border-radius: 8px;

}

.image-modal {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.modal-body-mobile {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 300px;

}

.id-background {
  background-color: rgba(248, 253, 255, 0.705);
  backdrop-filter: blur(5px);
}
</style>
