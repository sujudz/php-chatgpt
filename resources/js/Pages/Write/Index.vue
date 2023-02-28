<style>
.icon {
	width: 24px;
	height: 24px;
}
</style>

<template>
  <div>
    <Head title="AI Write" />
    <h1 class="mb-8 text-3xl font-bold">AI Write</h1>
    <div>
    	<section class="text-gray-600 body-font">
		  <div class="container px-5 py-5 mx-auto">
		    
		    <div class="flex flex-wrap -m-4">
		      
		      <div class="xl:w-1/3 md:w-1/2 p-4" v-for="prompt in prompts">
		      	<Link :href="prompt.link">

			        <div class="cursor-pointer border border-white p-6 bg-white rounded-lg">
			          <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
			            <img class="icon" :src="prompt.icon" />
			          </div>
			          <h2 class="text-lg text-gray-900 font-medium title-font mb-2">{{ prompt.title }}</h2>
			          <p class="leading-relaxed text-base">{{ prompt.desc }} </p>
			        </div>
			    </Link>
		      </div>
		      
		      
		    </div>
		  </div>
		</section>

    </div>
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
  props: {
    prompts: Object
  },
}
</script>
