<style>
  .icon {
    height: 36px;
    width: auto;
    max-width: 36px;
  }
</style>
<template>
<div>
    <Head title="PromptSetting" />
    <h1 class="mb-8 text-3xl font-bold">Prompt Setting</h1>
    <div class="flex items-center justify-between mb-6">
      
      <Link class="btn-indigo" href="/prompt/create">
        <span>+</span>
        <span class="hidden md:inline">&nbsp;Create</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Icon</th>
          <th class="pb-4 pt-6 px-6">Title</th>
          <th class="pb-4 pt-6 px-6">Desc</th>
        </tr>
        <tr v-for="prompt in prompts.data" :key="prompt.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/prompt/${prompt.id}/edit`">
              <div v-if="prompt.icon_type == 'png' "><img class="icon" :src="prompt.icon" /></div>
              <div v-else style="background-image:url(/img/icon_bg_blue.svg);background-size: cover;height: 36px;width: 36px;border-radius: 4px;">
              </div>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/prompt/${prompt.id}/edit`" tabindex="-1">
              {{ prompt.title }}
            </Link>
          </td>
          <td class="border-t">
            
            <div class="w-2/3">
              <Link class="flex items-center px-6 py-4" :href="`/prompt/${prompt.id}/edit`" tabindex="-1">
             {{ prompt.desc }}
              </Link>
            </div>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/prompt/${prompt.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="prompts.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No Prompts</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="prompts.links" />
  </div>

</template>


<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  props: {
    prompts: Object
  },
  layout: Layout,
  data() {
    return {
      form: this.$inertia.form({
        _method: 'post',
      }),
    }
  },
  methods: {
    
  },
}
</script>
