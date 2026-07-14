<ul class="nav nav-pills transfer-progress">
    <li class="nav-item">
        <div class="nav-link{{ ($step === 1) ? ' active' : '' }}">{{ translate(547) }}</div>
    </li>
    <li class="nav-item">
        <div class="nav-link{{ ($step === 2) ? ' active' : '' }}">{{ translate(419) }}</div>
    </li>
    <li class="nav-item">
        <div class="nav-link{{ ($step === 3) ? ' active' : '' }}">{{ translate(514) }}</div>
    </li>
</ul>

<style>
    @media screen and (max-width: 575px) {
        .profile-content .nav-pills.transfer-progress {
            display: flex;
            margin-bottom: 18px;
            box-shadow: none;
            overflow: hidden;
        }
        .profile-content .nav-pills.transfer-progress .nav-item {
            min-width: 0;
        }
        .profile-content .nav-pills.transfer-progress .nav-item:nth-child(1) {
            z-index: 3;
        }
        .profile-content .nav-pills.transfer-progress .nav-item:nth-child(2) {
            z-index: 2;
        }
        .profile-content .nav-pills.transfer-progress .nav-item:nth-child(3) {
            z-index: 1;
        }
        .profile-content .nav-pills.transfer-progress .nav-item .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 58px;
            padding: 8px 14px 8px 22px;
            background: #fff;
            color: #5c5c5c;
            font-size: 12px;
            line-height: 1.2;
            letter-spacing: 0;
            text-align: center;
            clip-path: none !important;
            -webkit-clip-path: none !important;
        }
        .profile-content .nav-pills.transfer-progress .nav-item:first-child .nav-link {
            padding-left: 12px;
        }
        .profile-content .nav-pills.transfer-progress .nav-item:not(:last-child) .nav-link::before,
        .profile-content .nav-pills.transfer-progress .nav-item:not(:last-child) .nav-link::after {
            position: absolute;
            top: 50%;
            width: 0;
            height: 0;
            content: '';
            transform: translateY(-50%);
        }
        .profile-content .nav-pills.transfer-progress .nav-item:not(:last-child) .nav-link::before {
            right: -14px;
            z-index: 1;
            border-top: 29px solid transparent;
            border-bottom: 29px solid transparent;
            border-left: 14px solid #dfe3e7;
        }
        .profile-content .nav-pills.transfer-progress .nav-item:not(:last-child) .nav-link::after {
            right: -12px;
            z-index: 2;
            border-top: 29px solid transparent;
            border-bottom: 29px solid transparent;
            border-left: 13px solid #fff;
        }
        .profile-content .nav-pills.transfer-progress .nav-item .nav-link.active {
            background: #287f7a;
            color: #fff;
        }
        .profile-content .nav-pills.transfer-progress .nav-item:not(:last-child) .nav-link.active::after {
            border-left-color: #287f7a;
        }
    }
</style>
