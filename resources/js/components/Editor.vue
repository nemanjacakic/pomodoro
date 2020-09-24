<template>
  <div>
    <textarea name="tiny" :class="'tiny-' + uniqueID"></textarea>
  </div>
</template>

<script>
import tinymce from "tinymce/tinymce";

import "tinymce/icons/default";

import "tinymce/themes/silver";

import "tinymce/plugins/link";
import "tinymce/plugins/image";
import "tinymce/plugins/code";
import "tinymce/plugins/table";
import "tinymce/plugins/textcolor";
import "tinymce/plugins/lists";

const INIT = 0;
const INPUT = 1;
const CHANGED = 2;

export default {
  props: {
    value: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      editor: null,
      status: INIT,
      uniqueID: Date.now()
    };
  },
  watch: {
    value(val) {
      if (val === null) return;

      if (!this.editor || !this.editor.initialized) return;

      if (this.status === CHANGED) {
        this.status = INPUT;
        return;
      }

      this.editor.setContent(val);
    }
  },
  mounted() {
    tinymce.init({
      selector: ".tiny-" + this.uniqueID,
      skin_url: "/js/skins/ui/oxide",
      file_picker_callback(callback, value, meta) {
        let x =
          window.innerWidth ||
          document.documentElement.clientWidth ||
          document.getElementsByTagName("body")[0].clientWidth;
        let y =
          window.innerHeight ||
          document.documentElement.clientHeight ||
          document.getElementsByTagName("body")[0].clientHeight;

        tinymce.activeEditor.windowManager.openUrl({
          url: "/file-manager/tinymce5",
          title: "Laravel File manager",
          width: x * 0.8,
          height: y * 0.8,
          onMessage: (api, message) => {
            callback(message.content, { text: message.text });
          }
        });
      },
      min_height: this.editorHeight || 350,
      resize: "vertical",
      plugins: "link, image, code, table, lists",
      extended_valid_elements:
        "input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]",
      toolbar:
        "styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code",
      convert_urls: false,
      image_caption: true,
      image_title: true,
      setup: editor => {
        this.editor = editor;
        editor.on("init", () => {
          editor.setContent(this.value);

          editor.on("input change undo redo execCommand KeyUp", () => {
            if (this.status === INPUT || this.status === INIT) {
              this.status = CHANGED;

              return;
            }
            this.$emit("input", editor.getContent());
          });
          editor.on("NodeChange", () => {
            this.$emit("input", editor.getContent());
          });
        });
      }
    });
  },
  beforeDestroy: function() {
    this.editor.remove();
  }
};
</script>
