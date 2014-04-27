<?php

namespace Application\View;

use Zend\View\Helper\AbstractHelper;
use Zend\Filter\FilterChain;
use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Filter\StringToLower;
use InvalidArgumentException;
use Exception;

/**
 * View Helper
 */
class GlyphIcons extends AbstractHelper
{
    /**
    * @var string
    */
    protected $color = "white";
    
    /**
     * @var string
     */
    protected $pFormat = '<p><i class="%s"></i>%s</p>';
    
    protected $aFormat = '<a href="%s" class="%s">%s</a>';
    
    protected $format = '<i class="%s"></i>';
    
    protected $options = array(
    	'white' => false,
        'text'  => '',
        'href'  => '',
    );
    
    /**
     * @var array
     */
    protected $icons = array(
        'glass', 'leaf', 'dog', 'user', 
        'girl', 'car', 'user_add',
        'user_remove', 'film', 'magic', 'envelope',
        'camera', 'heart', 'beach_umbrella', 'train',
        'print', 'bin', 'music', 'note',
        'heart_empty', 'home', 'snowflake', 'fire', 
        'magnet', 'parents', 'binoculars', 'road',
        'search', 'cars', 'notes_2', 'pencil',
        'bus', 'wifi_alt', 'luggage', 'old_man',
        'woman', 'file', 'coins', 'airplane', 
        'notes', 'stats', 'charts', 'pie_chart',
        'group','keys', 'calendar', 'router',
        'camera_small', 'dislikes', 'star', 'link',
        'eye_open', 'eye_close', 'alarm', 'clock',
        'stopwatch', 'projector', 'history', 'truck',
        'cargo', 'compass', 'keynote', 'paperclip',
        'power', 'lightbulb', 'tag', 'tags',
        'cleaning', 'ruller', 'gift', 'umbrella',
        'book', 'bookmark', 'wifi', 'cup',
        'stroller', 'headphones', 'headset', 'warning_sign',
        'signal', 'retweet', 'refresh', 'roundabout',
        'random', 'heat', 'repeat', 'display',
        'log_book', 'adress_book', 'building', 'eyedropper',
        'adjust', 'tint', 'crop', 'vector_path_square',
        'vector_path_circle', 'vector_path_polygon', 'vector_path_line', 'vector_path_curve',
        'vector_path_all', 'font', 'italic', 'bold',
        'text_underline', 'text_strike', 'text_height', 'text_width',
        'text_resize', 'left_indent', 'right_indent', 'align_left',
        'align_center', 'align_right', 'justify', 'list',
        'text_smaller', 'text_bigger', 'embed', 'embed_close',
        'table', 'message_full', 'message_empty', 'message_in',
        'message_out', 'message_plus', 'message_minus', 'message_ban',
        'message_flag', 'message_lock', 'message_new', 'inbox',
        'inbox_plus', 'inbox_minus', 'inbox_lock', 'inbox_in',
        'inbox_out', 'cogwheel', 'cogwheels', 'picture',
        'adjust_alt', 'database_lock', 'database_plus', 'database_minus',
        'database_ban', 'folder_open', 'folder_plus', 'folder_minus',
        'folder_lock', 'folder_flag', 'folder_new', 'edit',
        'new_window', 'check', 'unchecked', 'more_windows',
        'show_big_thumbnails', 'show_thumbnails', 'show_thumbnails_with_lines', 'show_lines',
        'playlist', 'imac', 'macbook', 'ipad',
        'iphone', 'iphone_transfer', 'iphone_exchange', 'ipod',
        'ipod_shuffle', 'ear_plugs', 'phone', 'step_backward',
        'fast_backward', 'rewind', 'play', 'pause',
        'stop', 'forward', 'fast_forward', 'step_forward',
        'eject', 'facetime_video', 'download_alt', 'mute',
        'volume_down', 'volume_up', 'screenshot', 'move',
        'more', 'brightness_reduce', 'brightness_increase', 'circle_plus',
        'circle_minus', 'circle_remove', 'circle_ok', 'circle_question_mark',
        'circle_info', 'circle_exclamation_mark', 'remove', 'ok',
        'ban', 'download', 'upload', 'shopping_cart',
        'lock', 'unlock', 'electricity', 'ok_2',
        'remove_2', 'cart_out', 'cart_in', 'left_arrow',
        'right_arrow', 'down_arrow', 'up_arrow', 'resize_small',
        'resize_full', 'circle_arrow_left', 'circle_arrow_right', 'circle_arrow_top',
        'circle_arrow_down', 'play_button', 'unshare', 'share',
        'chevron-right', 'chevron-left', 'bluetooth', 'euro',
        'usd', 'gbp', 'retweet_2', 'moon',
        'sun', 'cloud', 'direction', 'brush',
        'pen',  'zoom_in', 'zoom_out', 'pin',
        'albums', 'rotation_lock', 'flash', 'google_maps',
        'anchor', 'conversation', 'chat', 'male',
        'female', 'asterisk', 'divide', 'snorkel_diving',
        'scuba_diving', 'oxygen_bottle', 'fins', 'fishes',
        'boat', 'delete', 'sheriffs_star', 'qrcode',
        'barcode', 'pool', 'buoy', 'spade',
        'bank', 'vcard', 'electrical_plug', 'flag',
        'credit_card', 'keyboard-wireless', 'keyboard-wired', 'shield',
        'ring', 'cake', 'drink', 'beer',
        'fast_food', 'cutlery', 'pizza', 'birthday_cake',
        'tablet', 'settings', 'bullets', 'cardio',
        't-shirt', 'pants', 'sweater', 'fabric',
        'leather', 'scissors', 'bomb', 'skull',
        'celebration', 'tea_kettle', 'french_press', 'coffe_cup',
        'pot', 'grater', 'kettle', 'hospital',
        'hospital_h', 'microphone', 'webcam', 'temple_christianity_church',
        'temple_islam', 'temple_hindu', 'temple_buddhist', 'bicycle',
        'life_preserver', 'share_alt', 'comments', 'flower',
        'baseball', 'rugby', 'ax', 'table_tennis',
        'bowling', 'tree_conifer', 'tree_deciduous', 'more_items',
        'sort', 'filter', 'gamepad', 'playing_dices',
        'calculator', 'tie', 'wallet', 'piano',
        'sampler', 'podium', 'soccer_ball', 'blog',
        'dashboard', 'certificate', 'bell', 'candle',
        'pushpin', 'iphone_shake', 'pin_flag', 'turtle',
        'rabbit', 'globe', 'briefcase', 'hdd',
        'thumbs_up', 'thumbs_down', 'hand_right', 'hand_left',
        'hand_up', 'hand_down', 'fullscreen', 'shopping_bag',
        'book_open', 'nameplate', 'nameplate_alt', 'vases',
        'bullhorn', 'dumbbell', 'suitcase', 'file_import',
        'file_export', 'bug', 'crown', 'smoking',
        'cloud-upload', 'cloud-download', 'restart', 'security_camera',
        'expand', 'collapse', 'collapse_top', 'globe_af',
        'global', 'spray', 'nails', 'claw_hammer',
        'classic_hammer', 'hand_saw', 'riflescope', 'electrical_socket_eu',
        'electrical_socket_us', 'pinterest', 'dropbox', 'google_plus',
        'jolicloud', 'yahoo', 'blogger', 'picasa',
        'amazon', 'tumblr', 'wordpress', 'instapaper',
        'evernote', 'xing', 'zootool', 'dribbble',
        'deviantart', 'read_it_later', 'linked_in', 'forrst',
        'pinboard', 'behance', 'github', 'youtube', 'skitch',
        'foursquare', 'quora', 'badoo', 'spotify',
        'stumbleupon', 'readability', 'facebook', 'twitter',
        'instagram', 'posterous_spaces', 'vimeo', 'flickr',
        'last_fm', 'rss', 'skype', 'e-mail'
    );
    
    public function __invoke($options = array())
    {
        $this->setOptions($options);
        return $this;
    }
    
    protected function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }
    }
    
    /**
     * Display Icon
     *
     * @param  string                    $method
     * @param  array                     $argv
     * @throws \InvalidArgumentException
     * @return string
     */
    public function __call($method, $argv)
    {
        // check for int at end of method.
        $int = substr($method, -1) ;
        
        if (ctype_digit($int)) {
            $icon = substr($method, 0, -1) . '_' . $int;
            
        } else {
            $filterChain = new FilterChain();
            
            $filterChain->attach(new CamelCaseToUnderscore())
                ->attach(new StringToLower());
            
            $icon = $filterChain->filter($method);
        }
    
        if (!in_array($icon, $this->icons)) {
            //throw new InvalidArgumentException($icon . ' is not supported');
        }
    
        if ($argv) {
            $argv = (array) $argv[0];
        }
    
        return $this->render($icon, $argv);
    }
    
    public function p($text = '')
    {
        $this->options['text'] = $text;
        $this->format = 'pFormat';
        
        return $this;
    }
    
    public function a($href = '', $text = '')
    {
        $this->options['text'] = $text;
        $this->options['href'] = $href;
        $this->format = 'aFormat';
        
        return $this;
    }
    
    /**
     * Render Icon
     *
     * @param  string    $icon
     * @param  array     $options
     * @throws Exception
     * @return string
     */
    protected function render($icon, $options = array())
    {
        if (!in_array($icon, $this->icons)) {
            //throw new Exception($icon . ' icon is not supported');
        }
        
        $this->setOptions($options);
    
        $class = ($this->format == 'pFormat') ? 'glyphicons-icon' : 'glyphicons';
    
        if ($this->options['white']) {
            $class = ' ' . $this->color;
        }
    
        $class = trim($class . ' ' . $icon);
        
        if ($this->format == 'pFormat') {
            return sprintf($this->{$this->format}, $class, $this->options['text']);
        } elseif ($this->format == 'aFormat')  {
            return sprintf($this->{$this->format}, $this->options['href'], $class, $this->options['text']);
        } else {
            return sprintf($this->format, $class);
        }
    }
}
