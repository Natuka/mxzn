<template>
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
        <van-list v-model="loading" :finished="finished" @load="onLoad">
            <van-panel :key="key" v-for="(item, key) in data">
                <div class="p-20">
                    <van-cell-group>
                        <van-cell title="操作时间" :value="item.created_at"/>
                        <van-cell title="处理方式" :value="actionType()"/>
                        <van-cell title="工程师" :value="item.staff_name"/>
                        <van-cell title="处理网点" value="总部客服中心"/>
                        <van-cell title="到达时间" :value="item.arrived_at"/>
                        <van-cell title="完成时间" :value="item.complete_at"/>
                        <van-cell title="处理时长" :value="getDuring(item)"/>
                        <van-cell title="故障原因" :value="item.cause"/>
                        <van-cell title="" v-if="item.cause_docs && item.cause_docs.length">
                            <div style="display: flex">
                                <div v-for="(file) in item.cause_docs"
                                     :key="'cause_doc-' + file.id"
                                     v-if="isImage(file.name)"
                                     @click="showImage(file.id)">
                                    <img width="100" :src="fullUrl(file.id)" :alt="file.name">
                                </div>
                            </div>
                        </van-cell>
                        <van-cell title="处理措施/结果" :value="item.step_result"/>
                        <van-cell title="" v-if="item.step_docs && item.step_docs.length">
                            <div style="display: flex">
                                <div v-for="(file) in item.step_docs"
                                     :key="'step_docs-' + file.id"
                                     v-if="isImage(file.name)"
                                     @click="showImage(file.id)">
                                    <img width="100" :src="fullUrl(file.id)" :alt="file.name">
                                </div>
                            </div>
                        </van-cell>
                        <van-cell title="处理进度" :value="item.process"/>
                        <!-- <van-cell title="下步处理" :value="内容" label="下步处理"/>
                        <van-cell title="下步处理网点" :value="内容" label="下步处理网点"/>
                        <van-cell title="下步处理工程师" :value="内容" label="下步处理工程师"/>-->
                        <!-- <van-cell title="操作人员" :value="内容"/> -->
                    </van-cell-group>
                </div>
               <!-- <div slot="footer" class="text-right">
                    <van-button size="small" @click="onEdit(item)">修改</van-button>
                    <van-button size="small" @click="onRemove(item)">删除</van-button>
                </div>-->
            </van-panel>
        </van-list>
    </van-pull-refresh>
</template>

<script>
    import Action from "../actions";
    import actionMixin from "../../mixins/action";
    import infoMixin from "../../mixins/service-info";

    import {repairList, fetchRepairRepairList} from "../../api";
    import {Toast} from "vant";

    import dayjs from "dayjs";
    import { ImagePreview } from "vant";
    export default {
        name: "mx-repair-action-item",
        components: {
            [Action.name]: Action
        },
        mixins: [actionMixin, infoMixin],
        props: {
            type: {
                type: [Number, String],
                default: 0
            }
        },
        data() {
            return {
                active: 2,
                data: [],
                item: {},
                loading: false,
                finished: false,
                // menus: list,
                isLoading: false,
                value: "",
                page: 1,
                isRefresh: false
            };
        },

        computed: {
            serviceOrder() {
                return this.$store.getters.serviceOrder;
            }
        },

        methods: {
            fullUrl(id) {
                return "https://mp.mxhj.net/file/image/?id=" + id;
            },
            showImage(id) {
                ImagePreview([this.fullUrl(id)]);
            },
            // 判断是否是图片
            isImage(path = "") {
                if (!path) {
                    return false;
                }
                const ext = path
                    .split("?")[0]
                    .split(".")
                    .pop();
                if (!ext) {
                    return false;
                }

                return (
                    ["jpg", "jpeg", "gif", "png"].indexOf(String(ext).toLowerCase()) >= 0
                );
            },
            getDuring(item) {
                if (!item.complete_at) {
                    return dayjs().diff(item.arrived_at, "day") + "天";
                }
                return dayjs(item.complete_at).diff(item.arrived_at, "day") + "天";
            },

            actionType() {
                if (this.serviceOrder) {
                    if (+this.serviceOrder.is_out === 1) {
                        return "上门";
                    }
                    return "电话(远程)";
                }
                return "";
            },

            async onRefresh() {
                this.isRefresh = true;
                await this.loadData();
                await this.onLoad();
            },

            async setOrderInfo(info) {
                this.$store.dispatch("setServiceOrder", info);
                this.$router.push("/repair/info");
            },

            async loadData() {
                let dataWrap = this.data;
                if (this.isRefresh) {
                    this.loading = true;
                    this.finished = false;
                } else {
                    this.finished = false;
                }

                try {
                    const data = await fetchRepairRepairList(this.serviceOrder.id);
                    this.data = data;
                    this.finished = true;
                    this.isLoading = false;
                } catch (e) {
                } finally {
                    this.loading = false;
                    this.isLoading = false;
                }
            },

            async onLoad() {
                this.isRefresh = false;
                await this.loadData();
            },
            onSearch() {
            },
            onClick(item) {
                this.item = item;
                // this.$refs["action"].open();
            },
            onEdit(item) {
            },
            onRemove() {
            }
        }
    };
</script>
