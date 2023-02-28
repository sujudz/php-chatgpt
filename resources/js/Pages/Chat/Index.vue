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
    height: 510px;
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

  
            <div class="lg:w-2/3 md:w-1/2 bg-gray-300 rounded-lg sm:mr-10 flex items-end justify-start flex flex-col auto-height overflow-scroll p-6" ref="listContent">

                <div v-for="message in messages" :class="message.send" class="px-6 py-4 my-1 chat-box-content" style="max-width: 85%;" >
                  <div class="flex" v-if="message.send == 'self' ">
                    <div class="text-ellipsis break-all bg-white px-6 py-4 my-1 rounded-lg" v-html="message.content"></div>
                    <img class="ml-2" src="/img/me.png" />
                  </div>

                  <div class="flex"  v-if="message.send == 'third' ">
                    <img class="mr-2" src="/img/ai_avatar.png" />
                    <div class="text-ellipsis break-all bg-white px-6 py-4 my-1 rounded-lg" v-html="message.content"></div>
                  </div>
                </div>

                <div class="bg-white px-5 py-5 rounded-lg" v-if="messages.length <= 0">
                  <p class="mb-2">Click the text input box on the left to start using.</p>
                  <p class="mb-2">You can also choose or create a question template to ask questions about AI. The role of the template is mainly to improve the efficiency of questioning, because the more accurate you want ChatGPT to answer, the more information you need to provide it.</p>
                  <p class="mb-2">Using the template, you can preset the key information of the industry that needs to be asked, and then send it to the AI system along with the input questions.</p>
                </div>
            </div>

             <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-4 mt-4 md:mt-0">
              <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Start for ChatGPT</h2>
              <p class="leading-relaxed mb-5 text-gray-600">You can choose the appropriate question template to ask questions to AI through the following template, and you can get better answers.</p>
              <div class="relative mb-4">
                <label for="name" class="leading-7 text-sm text-gray-600">Prompt</label>
                
                <div class="flex">
                  <select type="select" id="promptTemplateId" name="promptTemplateId" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" v-model="chat.promptTemplateId">
                    <option >None</option>
                    <option :value="prompt.id" v-for="prompt in prompts">{{ prompt.title }}</option>
                  </select>
                
                  <Link class="btn-indigo ml-2" href="/prompt/create">
                    <span>+Create</span>
                  </Link>
                </div>

              </div>
              
              <div class="relative mb-4">
                <label for="title" class="leading-7 text-sm text-gray-600">Question Content</label>
                <textarea :error="form.errors.title" id="title" name="title" class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" v-model="chat.title"></textarea>
              </div>

              <div class="relative mb-4 flex" style="display:none;">
                <input type="checkbox" :error="form.errors.forcezh" id="forcezh" name="forcezh" class="bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" v-model="chat.forcezh" />
                <label for="forcezh" class="leading-7 text-sm text-gray-600 ml-2">Ask For Chinese</label>
                
              </div>

              <loading-button :loading="processing" @click='sendMessage' class="justify-center text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Send</loading-button>
            </div>

          </div>
        </section>

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

export default {
  components: {
    Head,
    Link,
    TextInput,
    SelectInput,
    LoadingButton
  },
  props: {
    chat: Object,
    prompts: Object
  },
  layout: Layout,
  data() {
    return {
      processing: false,
      form: this.$inertia.form({
        _method: 'post',
        title: this.chat.title,
        category: this.chat.category
      }),
      messages: []
    }
  },
  remember: 'form',
  updated() {
    //this.scrollToBottom();
  },
  methods: {
    formatContent(text) {
      return text.replaceAll('\n', '<br/>')
                  .replaceAll('\r\n', '<br/>')
                  .replaceAll(' ', '&nbsp;')
    },
    handleMessage(data) {
      console.log(data);
      this.processing = false;
      this.chat.id = data.chat.id;
      if (!data.responseData) {
        this.addSendMessage(this.formatContent('AI服务器出了点差错!'), "third");
        return;
      }
      if (data.responseData.error) {
        this.addSendMessage(this.formatContent(data.responseData.error.message), "third");
        return;
      }
      if (data.responseData.choices) {
        this.addSendMessage(this.formatContent(data.responseData.choices[0].text), "third");
      }
    },
    addSendMessage(title, send) {
      let src= "/img/ai_avatar.png";
      this.messages.push({ content: title, send:send, src: src});

      this.$nextTick(() => {
        let scrollElem = this.$refs.listContent;
          console.log(scrollElem.scrollHeight);
          scrollElem.scrollTo({ top: scrollElem.scrollHeight, behavior: 'smooth' });
      });
      
    },
    sendMessage() {
      this.$inertia.post('/chat', {
        title: this.chat.title,
        category: this.chat.category,
        id: this.chat.id,
        forcezh: this.chat.forcezh,
        promptTemplateId: this.chat.promptTemplateId
        }, {
        onStart: (data) => {this.processing = true},
        onSuccess: (data) => this.handleMessage(data.props),
      });

      if (this.chat.title != "") {
        this.addSendMessage(this.chat.title, "self");
      }
      
      this.chat.title = "";
    },
    scrollEvent(e) {
      
    }
  },
}
</script>
