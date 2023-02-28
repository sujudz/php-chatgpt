<style>
.self {
  align-self: flex-end;
}

.third {
  align-self: flex-start;
}

.auto-height {
  height: 760px;
}

@media screen and (max-width: 1440px) {
  .auto-height {
    height: 460px;
  }
}

::-webkit-scrollbar {
    display: none;
}

.chat-box-content img {
  height: 32px;
  width: 32px;
}
@scrrn
</style>

<template>
<div>
    <Head title="AI Chat" />

    <div class="bg-white rounded-md shadow overflow-hidden">
        <section class="text-gray-600 body-font relative">
          <div class="container px-4 py-4 mx-auto flex sm:flex-nowrap flex-wrap">

             <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-4 mt-4 md:mt-0">
              <p class="leading-relaxed mb-5 text-gray-600">{{ template.desc }}</p>
              <div class="relative mb-4">
                <label for="name" class="leading-7 text-sm text-gray-600">Select Prompt</label>
                
                <div class="flex">
                  <select type="select" id="promptTemplateId" name="promptTemplateId" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" v-model="form.promptTemplateId">
                    <option >None</option>
                    <option :value="prompt.id" v-for="prompt in prompts">{{ prompt.title }}</option>
                  </select>
                
                  <Link class="btn-indigo ml-2" href="/prompt/create">
                    <span>+Create</span>
                  </Link>
                </div>

              </div>
              
              <text-input v-model="form.title" :error="form.errors.appname" class="pb-8 mt-4 w-full" label="Primary Keyword" />

              <div class="relative mb-4">
                <label for="title" class="leading-7">Desc Keyword</label>
                <textarea v-model="form.subtitle" :error="form.errors.subtitle" id="subtitle" name="subtitle" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-24 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" ></textarea>
              </div>

              <loading-button :loading="processing" @click='sendMessage' class="justify-center text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Send</loading-button>
            </div>


            <div class="lg:w-2/3 md:w-1/2 bg-white rounded-lg sm:ml-10 auto-height p-6">

              <QuillEditor contentType="html" v-model:content="content" :options="options"
                @ready="ready($event)"
               />
            </div>

          </div>
        </section>

        <button @click='download' class="leading-tight bottom-16 right-1.5 fixed text-white bg-indigo-500 border-0  focus:outline-none hover:bg-indigo-600 rounded-full w-20 h-20 text-center text-lg">Down
        load</button>
    </div>
  </div>

</template>


<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import ChatTemplate from '@/Shared/ChatTemplate'
import { createApp } from 'vue'

import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
  components: {
    Head,
    Link,
    TextInput,
    SelectInput,
    LoadingButton,
    QuillEditor
  },
  props: {
    prompts: Object,
    template: Object
  },
  layout: Layout,
  data() {
    return {
      content: "",
      quill: null,
      processing: false,
      form: this.$inertia.form({
        _method: 'post',
        title: "",
        subtitle: '',
        promptTemplateId: ''
      }),
      options: {
        debug: 'info',
        modules: {
        },
        placeholder: 'input here...',
        readOnly: false,
        theme: 'snow'
      }
    }
  },
  remember: 'form',
  updated() {
  },
  methods: {
    onEditorChange({ quill, html, text }) {
      console.log('editor change!', quill, html, text)
      this.content = html
    },

    ready(quill) {
      console.log("ready");
      this.quill = quill;
    },
    
    handleMessage(data) {
      console.log(data);
      this.processing = false;
      var length = this.quill.getLength();
      this.quill.insertText(length, "\r\n" + data.responseData.choices[0].text, 'bold', true);
    },
    download() {
      var blob = new Blob([this.quill.getText()], {type: 'text/plain; charset=utf-8'}),
      blobUrl = URL.createObjectURL(blob),
      node = document.createElement('a');

      node.href = blobUrl;
      node.download = 'aiwrite.txt';

      node.click();
    },
    sendMessage() {
      this.$inertia.post('/write/create', {
        title: this.form.title,
        subtitle: this.form.subtitle,
        type: this.template.type,
        promptTemplateId: this.form.promptTemplateId
        }, {
        onStart: (data) => {this.processing = true},
        onSuccess: (data) => this.handleMessage(data.props),
        onCancel: (data) => {this.processing = false},
        onFinish: (data) => {this.processing = false},
        onError: (data) => {this.processing = false}
      });

    }
  },
}
</script>
