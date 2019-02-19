<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top" >
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $this->url->get('dashboard') ?>">Project name</a>
        </div>     
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <!-- <li class="active dropdown"> -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">설정 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">설정</a></li>
                        <li role="separator" class="divider"></li>                    
                        <li><a href="#">회원 설정</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= $this->url->get('dashboard/setup/board/') ?>">게시판 설정</a></li>
                    </ul>
                </li>
                <li><a href="<?= $this->url->get('dashboard/member/') ?>">회원</a></li>
                <!-- <li><a href="<?= $this->url->get('dashboard/board/board/') ?>">게시판</a></li> -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">게시판 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        {% for bbds in bbd %}
                        <li><a href="<?= $this->url->get('dashboard/board/')?>{{ bbds.id }}/">{{ bbds.name }}</a></li>
                        {% endfor %}
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {% if !userId  %}
                <li><a href="<?= $this->url->get('dashboard/login') ?>">로그인</a></li>
                {% else %}
                <li><a href="<?= $this->url->get('dashboard/dologout') ?>">로그아웃</a></li>
                <li><a href="<?= $this->url->get('dashboard/member/update/') ?>{{ userId }}">정보수정</a></li>
                {% endif %}
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">

    {{ content() }}

</div> <!-- /container -->

<footer class="footer">
    <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
    </div>
</footer>
