<?php

namespace PHPSTORM_META {

    use AndrewGos\ClassBuilder\ClassBuilderInterface;

    override(ClassBuilderInterface::build(0), map(['' => '@']));
    override(ClassBuilderInterface::buildArray(0), map(['' => '@[]']));
}
