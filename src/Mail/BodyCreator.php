<?php
namespace Mail\Mail;

use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class BodyCreator
{
	/**
	 * @var PhpRenderer
	 */
	private $phpRenderer;

	/**
	 * @param PhpRenderer $phpRenderer
	 */
	public function __construct(PhpRenderer $phpRenderer)
	{
		$this->phpRenderer = $phpRenderer;
	}

	/**
	 * @param Mail $mail
	 * @return string
	 */
	public function forMail(Mail $mail)
	{
		$placeholderValues = $mail->getPlaceholderValues()
			? $mail->getPlaceholderValues()->asArray()
			: [];

		$placeholderValues['subject'] = $mail->getSubject();

		$contentModel = new ViewModel(
			$placeholderValues
		);
		$contentModel->setTemplate($mail->getContentTemplate());

		$placeholderValues['content'] = $this->phpRenderer->render($contentModel);

		$layoutModel = new ViewModel($placeholderValues);
		$layoutModel->setTemplate($mail->getLayoutTemplate());

		return $this->phpRenderer->render($layoutModel);
	}
}