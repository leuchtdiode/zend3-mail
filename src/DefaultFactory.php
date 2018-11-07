<?php
namespace Mail;

use Common\AbstractDefaultFactory;

class DefaultFactory extends AbstractDefaultFactory
{
	protected function getNamespace()
	{
		return __NAMESPACE__;
	}
}