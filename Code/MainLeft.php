<div class="rs-faq faq-style1 p-0">
    <div class="faq-content p-0">
        <div id="accordion" class="accordion">
            <div class="card">
                <div class="card-header">
                    <a class="card-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">About Us</a>
                </div>
                <div id="collapseOne" class="collapse widget-area show" data-bs-parent="#accordion">
                    <div class="card-body categories">
                        <ul>
                            <li class="<?php echo $_CURRENT_PAGE_CODE == "ABOUT" ? 'active' : '' ?>">
                                <a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT")->PageName() ?></a>
                            </li>
                            <li class="<?php echo $_CURRENT_PAGE_CODE == "ABOUT2" ? 'active' : '' ?>">
                                <a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT2")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT2")->PageName() ?></a>
                            </li>
                            <li class="<?php echo $_CURRENT_PAGE_CODE == "ABOUT3" ? 'active' : '' ?>">
                                <a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT3")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT3")->PageName() ?></a>
                            </li>
                            <li class="<?php echo $_CURRENT_PAGE_CODE == "ABOUT4" ? 'active' : '' ?>">
                                <a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT4")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT4")->PageName() ?></a>
                            </li>
                            <li class="<?php echo $_CURRENT_PAGE_CODE == "ABOUT5" ? 'active' : '' ?>">
                                <a href="<?php echo $_Util_PageConfig->GetConfig("ABOUT5")->PageURLName() ?>"><?php echo $_Util_PageConfig->GetConfig("ABOUT5")->PageName() ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>