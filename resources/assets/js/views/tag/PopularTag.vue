<template>
    <div class="vue-popular-tags">
        <vue-tags-input
            :tags="tags"
            @before-deleting-tag="addCurrentTag"
        />
    </div>
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
import EventBus from '../../EventBus';

export default {
    name: "PopularTag",
    components: {
        VueTagsInput,
    },
    data() {
        return {
            tags: [],
            popularTags: [],
        };
    },
    mounted() {
        let $ideaId = document.getElementById('idea_id');
        if ($ideaId) {
            let ideaId = $ideaId.value;
            ideaId = ideaId ? ideaId : 0;
            axios.get('/get-idea/' + ideaId + '/popular-exclude-current-tags').then((res) => {
                let $tags = document.getElementById('popular_tags');
                if ($tags) {
                    let tags = $tags.value;
                    this.tags = tags ? JSON.parse(tags) : res.data;
                }
                Object.assign(this.popularTags, res.data);
            });
        }
        EventBus.$on('removePopularTag', (id) => {
            this.removeTag(id);
        });
        EventBus.$on('addPopularTag', (id, text) => {
            if (this.popularTags.find(x => x.id === id)) {
                this.tags.push({id: id, text: text});
            }
        });
    },
    methods: {
        addCurrentTag(obj) {
            let id = this.getPopularTagId(obj);
            EventBus.$emit('addCurrentTag', id, obj.tag.text);
            this.removeTag(id);
        },
        removeTag(id) {
            let index = this.tags.findIndex(x => x.id === id);
            if (index !== -1) {
                this.tags.splice(index, 1);
            }
        },
        getPopularTagId(obj) {
            let popularTag = this.tags.find(x => x.text === obj.tag.text);
            return popularTag ? popularTag.id : 0;
        }
    },
};
</script>

<style lang="css">
.vue-popular-tags .vue-tags-input {
    max-width: unset !important;
    margin-bottom: 0;
}
.vue-popular-tags .ti-input {
    border-style: none;
}
.vue-popular-tags .ti-icon-close:before {
    content: "\e900";
}
.vue-popular-tags .ti-new-tag-input {
    display: none;
}
</style>
