<?php

class Application_Form_Page extends Zend_Form {

	protected $_h1              = '';

	protected $_headerTitle     = '';

	protected $_url             = '';

	protected $_navName         = '';

	protected $_metaDescription = '';

	protected $_metaKeywords    = '';

	protected $_teaserText      = '';

	protected $_inMenu          = '';

	protected $_is404page       = false;

	protected $_protected       = false;

	protected $_parentId        = false;

	protected $_templateId      = '';

	protected $_pageId          = '';

	protected $_draft           = false;

	protected $_publishAt       = '';

	protected $_pageOption      = 0;

	public function init() {
		$this->setMethod(Zend_Form::METHOD_POST);

		$this->addElement(new Zend_Form_Element_Text(array(
			'id'       => 'h1',
			'name'     => 'h1',
			'label'    => 'Page header H1 tag',
			'value'    => $this->_h1,
			'required' => true,
			'filters'  => array('StringTrim')
		)));

		$this->addElement(new Zend_Form_Element_Text(array(
			'id'       => 'header-title',
			'name'     => 'headerTitle',
			'label'    => 'Display in browser title as',
			'value'    => $this->_headerTitle,
			'required' => true,
			'filters'  => array('StringTrim')
		)));

		$this->addElement(new Zend_Form_Element_Text(array(
			'id'       => 'url',
			'name'     => 'url',
			'label'    => 'Page URL in address bar',
			'value'    => $this->_url,
			'required' => true,
			'filters'  => array(
				new Zend_Filter_StringTrim('.'),
				//new Zend_Filter_Alnum(array('allowwhitespace' => true))
			)
		)));

		$this->addElement(new Zend_Form_Element_Text(array(
			'id'       => 'nav-name',
			'name'     => 'navName',
			'label'    => 'Display in navigation as',
			'value'    => $this->_navName,
			'required' => true,
			'filters'  => array('StringTrim')
		)));

		$this->addElement(new Zend_Form_Element_Textarea(array(
			'name'     => 'metaDescription',
			'id'       => 'meta-description',
			'cols'     => '45',
			'rows'     => '7',
			'label'    => 'Meta description',
			'class'    => 'h110',
			'value'    => $this->_metaDescription,
			'filters'  => array('StringTrim')
		)));

		$this->addElement(new Zend_Form_Element_Textarea(array(
			'name'     => 'metaKeywords',
			'id'       => 'meta-keywords',
			'cols'     => '45',
			'rows'     => '3',
			'label'    => 'Meta keywords',
			'class'    => 'h70',
			'value'    => $this->_metaKeywords,
			'filters'  => array('StringTrim')
		)));

		$this->addElement(new Zend_Form_Element_Textarea(array(
			'name'     => 'teaserText',
			'id'       => 'teaser-text',
			'cols'     => '45',
			'rows'     => '3',
			'label'    => 'Teaser Text',
			'value'    => $this->_teaserText,
			'class'    => array('hldd00', 'h130'),
			'filters'  => array('StringTrim')
		)));

		$this->addElement(new Zend_Form_Element_Radio(array(
			'name' => 'inMenu',
			'multiOptions' => array(
				Application_Model_Models_Page::IN_MAINMENU   => 'Main Menu',
				Application_Model_Models_Page::IN_STATICMENU => 'Flat Menu',
				Application_Model_Models_Page::IN_NOMENU     => 'No Menu'
			),
			'label'     => 'Navigation',
			'required'  => true,
			'separator' => ''
		)));

		$this->addElement(new Zend_Form_Element_Select(array(
			'name'         => 'pageCategory',
			'id'           => 'page-category',
			'label'        => 'Main menu',
			'multiOptions' => array(
				'Seotoaster' => array(
					Application_Model_Models_Page::IDCATEGORY_CATEGORY => 'This page is a category'
					//Application_Model_Models_Page::IDCATEGORY_PRODUCT  => 'Product pages'
				)
			),
			'registerInArrayValidator' => false
		)));

		$this->addElement(new Zend_Form_Element_Select(array(
			'name'         => 'pageOption',
			'id'           => 'page-options',
			'label'        => 'This page is',
			'multiOptions' => array(
				'0'                                           => 'Select an option',
				Application_Model_Models_Page::OPT_404PAGE    => 'our error 404 "Not found" page',
				Application_Model_Models_Page::OPT_PROTECTED  => 'accessible only to logged-in members',
				Application_Model_Models_Page::OPT_ERRLAND    => 'our membership login error page',
				Application_Model_Models_Page::OPT_MEMLAND    => 'where members land after logging-in',
				Application_Model_Models_Page::OPT_SIGNUPLAND => 'where members land after signed-up',
				Application_Model_Models_Page::OPT_CHECKOUT   => 'the cart checkout page'
			),
			'registerInArrayValidator' => false,
			'value' => $this->_pageOption
		)));

		$this->addElement(new Zend_Form_Element_Checkbox(array(
			'name'    => 'is404page',
			'id'      => '404-page',
			'label'   => 'Not found 404 page',
			'value'   => $this->_is404page,
			'checked' => ($this->_is404page) ? 'checked' : ''
		)));

		$this->addElement(new Zend_Form_Element_Checkbox(array(
			'name'    => 'protected',
			'id'      => 'protected-page',
			'label'   => 'Member only area',
			'value'   => $this->_protected,
			'checked' => ($this->_protected) ? 'checked' : ''
		)));

		$this->addElement(new Zend_Form_Element_Hidden(array(
			'id'       => 'templateId',
			'name'     => 'templateId',
			'required' => true,
			'label'    => 'Current template',
			'value'    => $this->_templateId
		)));

		$this->addElement(new Zend_Form_Element_Hidden(array(
			'id'    => 'pageId',
			'name'  => 'pageId',
			'value' => $this->_pageId
		)));

		$this->addElement(new Zend_Form_Element_Hidden(array(
			'id'    => 'draft',
			'name'  => 'draft',
			'value' => $this->_draft
		)));

		$this->addElement(new Zend_Form_Element_Hidden(array(
			'id'    => 'publish-at',
			'name'  => 'publishAt',
			'value' => $this->_publishAt
		)));

		$this->addElement(new Zend_Form_Element_Submit(array(
			'name'  => 'updatePage',
			'id'    => 'update-page',
			'value' => 'Save page',
			'label' => 'Save page'
		)));

		//$this->setDecorators(array('ViewScript'));
		$this->setElementDecorators(array('ViewHelper', 'Label'));
		$this->getElement('updatePage')->removeDecorator('Label');
	}

	public function getH1() {
		return $this->_h1;
	}

	public function setH1($h1) {
		$this->_h1 = $h1;
		$this->getElement('h1')->setValue($h1);
		return $this;
	}

	public function getHeaderTitle() {
		return $this->_headerTitle;
	}

	public function setHeaderTitle($headerTitle) {
		$this->_headerTitle = $headerTitle;
		$this->getElement('headerTitle')->setValue($headerTitle);
		return $this;
	}

	public function getUrl() {
		return $this->_url;
	}

	public function setUrl($url) {
		$this->_url = preg_replace('~\.[a-z0-9-]+$~ui', '', $url);
		$this->getElement('url')->setValue($this->_url);
		return $this;
	}

	public function getNavName() {
		return $this->_navName;
	}

	public function setNavName($navName) {
		$this->_navName = $navName;
		$this->getElement('navName')->setValue($navName);
		return $this;
	}

	public function getMetaDescription() {
		return $this->_metaDescription;
	}

	public function setMetaDescription($metaDescription) {
		$this->_metaDescription = $metaDescription;
		$this->getElement('metaDescription')->setValue($metaDescription);
		return $this;
	}

	public function getMetaKeywords() {
		return $this->_metaKeywords;
	}

	public function setMetaKeywords($metaKeywords) {
		$this->_metaKeywords = $metaKeywords;
		$this->getElement('metaKeywords')->setValue($metaKeywords);
		return $this;
	}

	public function getTeaserText() {
		return $this->_teaserText;
	}

	public function setTeaserText($teaserText) {
		$this->_teaserText = $teaserText;
		$this->getElement('teaserText')->setValue($teaserText);
		return $this;
	}

	public function setShowInMenu($showInMenu) {
		$this->_inMenu = $showInMenu;
		return $this;
	}

	public function getShowInMenu() {
		return $this->_inMenu;
	}

	public function getIs404page() {
		return $this->_is404page;
	}

	public function setIs404page($is404page) {
		$this->_is404page  = $is404page; // deprecated
		if($is404page) {
			$this->_pageOption = Application_Model_Models_Page::OPT_404PAGE;
			$this->getElement('pageOption')->setValue(Application_Model_Models_Page::OPT_404PAGE);
		}
		return $this;
	}

	public function getProtected() {
		return $this->_protected;
	}

	public function setProtected($protected) {
		$this->_protected = $protected; // deprecated
		if($protected) {
			$this->_pageOption = Application_Model_Models_Page::OPT_PROTECTED;
			$this->getElement('pageOption')->setValue(Application_Model_Models_Page::OPT_PROTECTED);
		}
		return $this;
	}

	public function setMemLanding($memLanding) {
		if($memLanding) {
			$this->_pageOption = Application_Model_Models_Page::OPT_MEMLAND;
			$this->getElement('pageOption')->setValue(Application_Model_Models_Page::OPT_MEMLAND);
		}
		return $this;
	}

	public function setCheckout($checkout) {
		if($checkout) {
			$this->_pageOption = Application_Model_Models_Page::OPT_CHECKOUT;
			$this->getElement('pageOption')->setValue(Application_Model_Models_Page::OPT_CHECKOUT);
		}
		return $this;
	}

	public function setErrLoginLanding($errLanding) {
		if($errLanding) {
			$this->_pageOption = Application_Model_Models_Page::OPT_ERRLAND;
			$this->getElement('pageOption')->setValue(Application_Model_Models_Page::OPT_ERRLAND);
		}
		return $this;
	}

	public function setSignupLanding($signupLanding) {
		if($signupLanding) {
			$this->_pageOption = Application_Model_Models_Page::OPT_SIGNUPLAND;
			$this->getElement('pageOption')->setValue(Application_Model_Models_Page::OPT_SIGNUPLAND);
		}
		return $this;
	}

	public function getParentId() {
		return $this->_parentId;
	}

	public function setParentId($parentId) {
		$this->_parentId = $parentId;
		$this->getElement('pageCategory')->setValue($parentId);
		return $this;
	}

	public function getTemplateId() {
		return $this->_templateId;
	}

	public function setTemplateId($templateId) {
		$this->_templateId = $templateId;
		$this->getElement('templateId')->setValue($templateId);
		return $this;
	}

	public function getPageId() {
		return $this->_pageId;
	}

	public function setPageId($pageId) {
		$this->_pageId = $pageId;
		$this->getElement('pageId')->setValue($pageId);
		return $this;
	}

	public function getDraft() {
		return $this->_draft;
	}

	public function setDraft($draft) {
		$this->_draft = $draft;
		$this->getElement('draft')->setValue($draft);
		return $this;
	}

	public function getPublishAt() {
		return $this->_publishAt;
	}

	public function setPublishAt($publishAt) {
		$this->_publishAt = $publishAt;
		$this->getElement('publishAt')->setValue($publishAt);
		return $this;
	}

	public function getMainMenuOptions() {
		return $this->getElement('pageCategory')->getMultiOptions();
	}

}

