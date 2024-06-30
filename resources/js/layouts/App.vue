<template>
    <div class="p-2" style="width: 100%;">
        <div @click="$event => $router.go(-1)" class="pt-2" style="width: 40px; height: 40px; float: left; cursor: pointer;">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </div>
        <div class="pt-1" style="width: calc(100% - 80px); height: 40px; float: left;">
            <p class="text-center mt-1 font-semibold">
                {{ currentTitlePage }}
            </p>
        </div>
        <div class="search-button" style="width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 130%;" v-if="isForderPage">
            <router-link :to="{name: 'FileSearch'}">
                <i class="fa fa-search" aria-hidden="true"></i>
            </router-link>
        </div>
        <div class="search-button" style="width: 40px; height: 40px;float:left; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 130%;" v-if="!isForderPage">
            <router-link :to="{name: 'ForderEdit'}">
                <i class="fa fa-cog" aria-hidden="true"></i>
            </router-link>
        </div>
    </div>
    <router-view></router-view>
</template>

<script>
export default {
    data() {
        return {
            formData: {
                name: ""
            }
        }
    },
    computed: {
        currentTitlePage() {
            return this.$route?.meta?.title || "";
        },
        isForderPage(){
        return this.$route?.meta?.title == "File List" ? false : true;
      }
    }
};
</script>
