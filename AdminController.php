<?php
/**
 * @package   ImpressPages
 */

namespace Plugin\AdvertTile;


class AdminController
{

    /**
     * WidgetSkeleton.js ask to provide widget management popup HTML. This controller does this.
     * @return \Ip\Response\Json
     * @throws \Ip\Exception\View
     */
    public function widgetPopupHtml()
    {
        $widgetId = ipRequest()->getQuery('widgetId');
        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        //create form prepopulated with current widget data
        $form = $this->managementForm($widgetData);

        //Render form and popup HTML
        $viewData = array(
            'form' => $form
        );
        $popupHtml = ipView('view/editPopup.php', $viewData)->render();
        $data = array(
            'popup' => $popupHtml
        );
        //Return rendered widget management popup HTML in JSON format
        return new \Ip\Response\Json($data);
    }


    /**
     * Check widget's posted data and return data to be stored or errors to be displayed
     */
    public function checkForm()
    {
        $data = ipRequest()->getPost();
        $form = $this->managementForm();
        $data = $form->filterValues($data); //filter post data to remove any non form specific items
        $errors = $form->validate($data); //http://www.impresspages.org/docs/form-validation-in-php-3
        if ($errors) {
            //error
            $data = array (
                'status' => 'error',
                'errors' => $errors
            );
        } else {
            //success
            unset($data['aa']);
            unset($data['securityToken']);
            unset($data['antispam']);
            $data = array (
                'status' => 'ok',
                'data' => $data

            );
        }
        return new \Ip\Response\Json($data);
    }

    protected function managementForm($widgetData = array())
    {
        $form = new \Ip\Form();

        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        //setting hidden input field so that this form would be submitted to 'errorCheck' method of this controller. (http://www.impresspages.org/docs/controller)
        $field = new \Ip\Form\Field\Hidden(
            array(
                'name' => 'aa',
                'value' => 'AdvertTile.checkForm'
            )
        );

        //ADD YOUR OWN FIELDS
        $nameField = new \Ip\Form\Field\Text([
            'name' => 'title',
            'label' => 'Title',
            'value' => !empty($widgetData['title']) ? $widgetData['title'] : null
        ]);
        $nameField->addValidator('Required');

        $urlField = new \Ip\Form\Field\Url([
            'name' => 'url',
            'label' => 'Information page',
            'value' => !empty($widgetData['url']) ? $widgetData['url'] : null,
            'default' => null
        ]);

        $payPalUrlField = new \Ip\Form\Field\Text([
            'name' => 'paypal',
            'label' => 'PayPal Id',
            'note' => 'The value located in the input-field "hosted_button_id"',
            'value' => !empty($widgetData['paypal']) ? $widgetData['paypal'] : null,
            'default' => null
        ]);

        $descriptionField = new \Ip\Form\Field\RichText([
            'name' => 'description',
            'label' => 'Description',
            'note' => 'Short description of the product.',
            'value' => !empty($widgetData['description']) ? $widgetData['description'] : null
        ]);

        $priceField = new \Ip\Form\Field\Text([
            'name' => 'price',
            'label' => 'Price',
            'value' => !empty($widgetData['price']) ? $widgetData['price'] : null
        ]);

        $imgField = new \Ip\Form\Field\RepositoryFile([
            'name' => 'img',
            'label' => 'Thumbnail',
            'value' => !empty($widgetData['img']) ? $widgetData['img'] : null,
            'preview' => 'thumbnails', //or list. This defines how files have to be displayed in the repository browser
            'fileLimit' => 1, //optional. Limit file count that can be selected. -1 For unlimited
            'filterExtensions' => array('jpg', 'jpeg', 'png') //optional
        ]);

        $apendixField = new \Ip\Form\Field\RepositoryFile([
            'name' => 'apendix',
            'label' => 'Apendix',
            'note' => 'Hidden behind the Read more button (will override Information page)',
            'value' => !empty($widgetData['apendix']) ? $widgetData['apendix'] : null,
            'preview' => 'list', //or list. This defines how files have to be displayed in the repository browser
            'fileLimit' => 1 //optional. Limit file count that can be selected. -1 For unlimited
            //'filterExtensions' => array('jpg', 'jpeg', 'png') //optional
        ]);

        // Register fields to form
        $form->addField($field); // Keep at top

        $form->addField($nameField);
        $form->addField($priceField);
        $form->addField($descriptionField);
        $form->addField($apendixField);
        $form->addField($urlField);
        $form->addField($payPalUrlField);
        $form->addField($imgField);

        return $form;
    }



}
