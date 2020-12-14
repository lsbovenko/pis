window.axios = require('axios');
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

import Vue from 'vue'
import PopularTag from './views/tag/PopularTag'
import Tag from './views/tag/Tag'
import SimilarIdea from './views/tag/SimilarIdea'

Vue.config.productionTip = false;
Vue.config.devtools = true;

new Vue({
    el: '#event_bus',
    components: { PopularTag, Tag }
});

var popularTag = new Vue({
    el: '#popular_tag',
    template: '<PopularTag/>',
    components: { PopularTag }
});

var tag = new Vue({
    el: '#tag',
    template: '<Tag/>',
    components: { Tag }
});

var similarIdea = new Vue({
    el: '#similar_idea',
    template: '<SimilarIdea/>',
    components: { SimilarIdea }
});

new Vue({
    el: '#add_idea_button',
    methods: {
        onClickAddIdea() {
            setTagData();
            document.getElementById('add_idea_submit').click();
        }
    }
});

new Vue({
    el: '#edit_idea_button',
    methods: {
        onClickEditIdea() {
            setTagData();
            document.getElementById('edit_idea_submit').click();
        }
    }
});

function setTagData() {
    document.getElementById('popular_tags').value = JSON.stringify(popularTag.$children[0].tags);
    document.getElementById('tags').value = JSON.stringify(tag.$children[0].tags);
    document.getElementById('similar_ideas').value = JSON.stringify(similarIdea.$children[0].tags);
}
