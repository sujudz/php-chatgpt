<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
    <div>
    	<section class="text-gray-600 body-font">
		  <div class="container px-5 py-5 mx-auto">
		    
		    <div class="flex flex-wrap -m-4">
		      
		      <div class="xl:w-1/3 md:w-1/2 p-4">
		      	<Link href="/prompt/create">

			        <div class="cursor-pointer border border-white p-6 bg-white rounded-lg">
			          <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
			            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
			              <circle cx="6" cy="6" r="3"></circle>
			              <circle cx="6" cy="18" r="3"></circle>
			              <path d="M20 4L8.12 15.88M14.47 14.48L20 20M8.12 8.12L12 12"></path>
			            </svg>
			          </div>
			          <h2 class="text-lg text-gray-900 font-medium title-font mb-2">AI Chat</h2>
			          <p class="leading-relaxed text-base">You can initiate an intelligent conversation with AI at any time, and every conversation record will be kept to let AI remember you.</p>
			        </div>
			    </Link>
		      </div>
		      <div class="xl:w-1/3 md:w-1/2 p-4">
		        <div class="border cursor-pointer border-white p-6 bg-white rounded-lg">
		          <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
		            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
		              <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
		              <circle cx="12" cy="7" r="4"></circle>
		            </svg>
		          </div>
		          <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Prompt Template</h2>
		          <p class="leading-relaxed text-base">The template can be used to quickly launch professional questions in a certain field, making it easier for AI to give correct answers.</p>
		        </div>
		      </div>
		      <div class="xl:w-1/3 md:w-1/2 p-4">
		        <div class="border cursor-pointer border-white p-6 bg-white rounded-lg">
		          <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
		            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
		              <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1zM4 22v-7"></path>
		            </svg>
		          </div>
		          <h2 class="text-lg text-gray-900 font-medium title-font mb-2">AT Tools</h2>
		          <p class="leading-relaxed text-base">Integrate multiple AI-based dialogue writing tools.</p>
		          <p class="leading-relaxed text-base">The current version supports Smart Conversation</p>
		        </div>
		      </div>
		      <div class="xl:w-1/3 md:w-1/2 p-4">
		        <div class="border cursor-pointer border-white p-6 bg-white rounded-lg">
		          <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
		            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
		              <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
		            </svg>
		          </div>
		          <h2 class="text-lg text-gray-900 font-medium title-font mb-2">System Status</h2>
		          <p class="leading-relaxed text-base">
		          	<span>API:ChatGPT</span><br>
		          	<span>model:text-davinci-003</span>
		          </p>
		        </div>
		      </div>
		      
		    </div>
		  </div>
		</section>

    </div>
    <p class="ml-6 leading-relaxed text-base">Version: v1.0</p>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Head,
    Link
  },
  layout: Layout,
}
</script>
