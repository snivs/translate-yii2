<?php

namespace snivs\translate;

use Yii;

/**
 * A helper class for Yii2's i18n built in capabilities, for readability.
 *
 * Usage: Translat::e("Message");
 * Uses the argument in Yii::t as the message.
 * Uses the category specified by using the getCategory method, or defaults
 * to Yii::$app->controller->uniqueId when nothing is specified.
 * 
 * Usage: Translat::e($array);
 * Searches for the following indexes:
 * - 'category': Optional, Overrides the default category in the class.
 * - 'message': Required, the message to be translated.
 * - 'params': Optional, Params to be used in the translation.
 * - 'language': Optional, language to override the default app target language.
 * 
 * @author Auden Lujan <audn.lujan@gmail.com>
 */
class Translat {
    
    /**
     * Category to use with Yii::t method in case none is specified in the e
     * method.
     * @var string|null
     */
    private static $category = null;
    
    /**
     * Set the category to use with Yii::t method in case none is specified
     * in the e method, set null to disable the Translat category.
     * @param string|null $category
     */
    static function setCategory($category){
        if (!is_string($category)){
            Yii::trace("Unable to set i18n category outside of string or null, received: ".gettype($category),'snivs\translate');
        }
        self::$category=$category;
    }
    
    /**
     * Set the category to use with Yii::t method in case none is specified
     * in the e method.
     * @return type
     */
    static function getCategory(){
        if (self::$category!==null){
            return self::$category;
        }
        return Yii::$app->controller->uniqueId;
    }
    
    /**
     * Translat-e a message!
     * @param string|array $args, message to be translated or array including
     * 'category','message','params' and 'language.
     * - 'category': Optional, Overrides the default category in the class.
     * - 'message': Required, the message to be translated.
     * - 'params': Optional, Params to be used in the translation.
     * - 'language': Optional, language to override the default app target language.
     * @return string|null the translated message or null if an untranslatable 
     * object is received (null is replaced with 'NON_TRANSLATABLE' in debug mode)
     */
    static function e($args){
        if (is_string($args)){
            return Yii::t(self::getCategory(), $args);
        }
        if(!is_aray($args)){
            Yii::trace("Unable to i18n object other than string or array: ".gettype($args),'snivs\translate');
            return YII_DEBUG?"NOT_TRANSLATABLE":null;
        }
        if(!isset($args['category'])){$args['category']=self::getCategory();}
        if(!isset($args['message'])){
            Yii::trace("Unable to translate without message: ".var_export($args),'snivs\translate');
            return YII_DEBUG?"NOT_TRANSLATABLE":null;
        }
        if(!isset($args['params'])){$args['params']=[];}
        if(!isset($args['language'])){$args['language']=Yii::$app->language;}
        return Yii::t($args['category'], $args['message'], $args['params'], $args['language']);
    }
    
    static function t($args){
        if (is_string($args)){
            return Yii::t(self::getCategory(), $args);
        }
        if(!is_aray($args)){
            Yii::trace("Unable to i18n object other than string or array: ".gettype($args),'snivs\translate');
            return YII_DEBUG?"NOT_TRANSLATABLE":null;
        }
        if(!isset($args['category'])){$args['category']=self::getCategory();}
        if(!isset($args['message'])){
            Yii::trace("Unable to translate without message: ".var_export($args),'snivs\translate');
            return YII_DEBUG?"NOT_TRANSLATABLE":null;
        }
        if(!isset($args['params'])){$args['params']=[];}
        if(!isset($args['language'])){$args['language']=Yii::$app->language;}
        return Yii::t($args['category'], $args['message'], $args['params'], $args['language']);
    }
}
