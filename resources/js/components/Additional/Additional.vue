<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Additional List Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let breadcrumb = '<router-link to="/additional">Additional</router-link>';
            console.log(breadcrumb);
            $('#crumb').html(breadcrumb);
        }
    }
</script>
