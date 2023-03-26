<template>
    <Banner />
    <section class="light-content services">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="service-box-wrap">
                        <div class="service-icon-wrap">
                            <i class="fa fa-pencil-square-o fa-2x"></i>
                        </div> <!-- /.service-icon-wrap -->
                        <div class="service-cnt-wrap">
                            <h3 class="service-title">{{ $t("Do not be pessimistic") }}</h3>
                            <p>{{ $t("A bad workman always blames his tools") }}</p>
                        </div> <!-- /.service-cnt-wrap -->
                    </div> <!-- /.service-box-wrap -->
                </div> <!-- /.col-md-4 -->

                <div class="col-md-4 col-sm-4">
                    <div class="service-box-wrap">
                        <div class="service-icon-wrap">
                            <i class="fa fa-calendar fa-2x"></i>
                        </div> <!-- /.service-icon-wrap -->
                        <div class="service-cnt-wrap">
                            <h3 class="service-title">{{ $t("The part affects the whole") }}</h3>
                            <p>
                                {{ $t("A chain is only as strong as its weakest link") }}
                            </p>
                        </div> <!-- /.service-cnt-wrap -->
                    </div> <!-- /.service-box-wrap -->
                </div> <!-- /.col-md-4 -->

                <div class="col-md-4 col-sm-4">
                    <div class="service-box-wrap">
                        <div class="service-icon-wrap">
                            <i class="fa fa-anchor fa-2x"></i>
                        </div> <!-- /.service-icon-wrap -->
                        <div class="service-cnt-wrap">
                            <h3 class="service-title">{{ $t("do not make it too much") }}</h3>
                            <p>{{ $t("Don’t make a mountain out of a molehill") }}</p>
                        </div> <!-- /.service-cnt-wrap -->
                    </div> <!-- /.service-box-wrap -->
                </div> <!-- /.col-md-4 -->

            </div>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="service-box-wrap">
                        <div class="service-icon-wrap">
                            <i class="fa fa-pencil-square-o fa-2x"></i>
                        </div> <!-- /.service-icon-wrap -->
                        <div class="service-cnt-wrap">
                            <h3 class="service-title">{{ $t("BIRD_HEADER") }}</h3>
                            <p>{{ $t("BIRD_CONTEXT") }}</p>
                        </div> <!-- /.service-cnt-wrap -->
                    </div> <!-- /.service-box-wrap -->
                </div> <!-- /.col-md-4 -->

                <div class="col-md-4 col-sm-4">
                    <div class="service-box-wrap">
                        <div class="service-icon-wrap">
                            <i class="fa fa-calendar fa-2x"></i>
                        </div> <!-- /.service-icon-wrap -->
                        <div class="service-cnt-wrap">
                            <h3 class="service-title">{{ $t("Start with first step") }}</h3>
                            <p>{{ $t("A journey of thousand miles begins with a single step") }}</p>
                        </div> <!-- /.service-cnt-wrap -->
                    </div> <!-- /.service-box-wrap -->
                </div> <!-- /.col-md-4 -->

                <div class="col-md-4 col-sm-4">
                    <div class="service-box-wrap">
                        <div class="service-icon-wrap">
                            <i class="fa fa-anchor fa-2x"></i>
                        </div> <!-- /.service-icon-wrap -->
                        <div class="service-cnt-wrap">
                            <h3 class="service-title">{{ $t("Avoid fear") }}</h3>
                            <p>{{ $t("Cowards die many times before their deaths") }}</p>
                        </div> <!-- /.service-cnt-wrap -->
                    </div> <!-- /.service-box-wrap -->
                </div> <!-- /.col-md-4 -->

            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section> <!-- /.services -->
    <Blogs />
</template>

<script>
import Banner from "./banner";
import Blogs from "./blogs";
export default {
    components: {
        Banner,
        Blogs,
    }
};
</script>

<style></style>
