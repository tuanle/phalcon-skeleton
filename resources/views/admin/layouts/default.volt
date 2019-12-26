<!DOCTYPE html>
<html>
    {% include 'admin/partials/head.volt' %}
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            {% include 'admin/partials/navbar.volt' %}
            {% include 'admin/partials/sidebar.volt' %}

            <div class="content-wrapper pl-3 pr-3">
                <session class="content-header">
                    {% block header %}{% endblock %}
                </session>

                <session class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                {{ flashSession.output() }}
                            </div>
                        </div>

                        {% block content %}{% endblock %}
                    </div>
                </session>
            </div>

            {% include 'admin/partials/footer.volt' %}
        </div>
        {% include 'admin/partials/javascripts.volt' %}
        {% block javascripts %}{% endblock %}
    </body>
</html>
