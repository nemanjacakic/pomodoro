<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" id="fm-main-block">
        <FileManager />

        <div class="input-group">
          <input
            type="text"
            id="image_label"
            class="form-control"
            name="image"
            aria-label="Image"
            aria-describedby="button-image"
          />
          <div class="input-group-append">
            <button
              class="btn btn-outline-secondary"
              type="button"
              id="button-image"
            >
              Select
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import fm from "laravel-file-manager/src/store";

import FileManager from "~/components/FileManager";

export default {
  components: {
    FileManager
  },
  mounted() {
    document.addEventListener("DOMContentLoaded", function() {
      // set fm height
      document
        .getElementById("fm-main-block")
        .setAttribute("style", "height:" + window.innerHeight + "px");

      const FileBrowserDialogue = {
        init: function() {
          // Here goes your code for setting your custom things onLoad.
        },
        mySubmit: function(URL) {
          // pass selected file path to TinyMCE
          parent.postMessage({
            mceAction: "insert",
            content: URL,
            text: URL.split("/").pop()
          });
          // close popup window
          parent.postMessage({ mceAction: "close" });
        }
      };

      // Add callback to file manager
      this.$store.commit("fm/setFileCallBack", function(fileUrl) {
        FileBrowserDialogue.mySubmit(fileUrl);
      });
    });
  }
};
</script>