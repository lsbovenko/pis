<template>
    <div class="left-sidebar sameblock">
        <section class="item">
            <ul>
                <li class="first">Автор</li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Кукареко А" id="name-1">Кукареко А (6)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Грамузов В" id="name-2">Грамузов В (2)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Ивашкин В" id="name-3">Ивашкин В (1)</span>
                    </label>
                </li>
                <li class="last"><a href="#">More</a></li>
            </ul>
        </section>
        <section class="item">
            <ul>
                <li class="first">
                    Отдел
                    <span class="drop">Сбросить</span>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Ruby разработки" id="data-1">Ruby разработки (6)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="UI/UX" id="data-2">UI/UX (2)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Кадров" id="data-3">Кадров (1)</span>
                    </label>
                </li>
            </ul>
        </section>
        <section class="item">
            <ul>
                <li class="first">Операционная цель</li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Вступление в ПВТ" id="data-4">Вступление в ПВТ (6)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Удовлетворенность клиентов" id="data-5">Удовлетворенность клиентов (2)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Другая" id="data-6">Другая (1)</span>
                    </label>
                </li>
            </ul>
        </section>
        <section class="item">
            <ul>
                <li class="first">Основная компетенция</li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Продажи" id="data-7">Продажи (6)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Кадры" id="data-8">Кадры (2)</span>
                    </label>
                </li>
                <li>
                    <label class="inbtn">
                        <input type="checkbox">
                        <span class="inbtn__indicator"></span>
                        <span class="data" data-title="Другая" id="data-9">Другая (1)</span>
                    </label>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
    export default {
        name: "MainFilterBlock",
        data() {
            return {

            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            fetch() {

            }
        }
    }
</script>

<style scoped>

</style>