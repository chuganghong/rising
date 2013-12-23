<?PHP
function smarty_function_create_pages($params, &$smarty)
{
	extract($params);

	if (empty($page))
	{
		$page = 1;
	}

	if (!empty($count))
	{
		$str = "<option value='1'>1</option>";
		$min = min($count - 1, $page + 3);
		for ($i = $page - 3 ; $i <= $min ; $i++)
		{
			if ($i < 2)
			{
				continue;
			}
			$str .= "<option value='$i'";
			$str .= $page == $i ? " selected='true'" : '';
			$str .= ">$i</option>";
		}
		if ($count > 1)
		{
			$str .= "<option value='$count'";
			$str .= $page == $count ? " selected='true'" : '';
			$str .= ">$count</option>";
		}
	}
	else
	{
		$str = '';
	}

	return $str;
}

/*function smarty_function_create_pages1($params)
{
    extract($params);

    $str = '';
    $len = 10;

    if (empty($page))
    {
        $page = 1;
    }

    if (!empty($count))
    {
        $step = 1;
        $str .= "<option value='1'>1</option>";

        for ($i = 2; $i < $count; $i += $step)
        {
            $step = ($i >= $page + $len - 1 || $i <= $page - $len + 1) ? $len : 1;
            $str .= "<option value='$i'";
            $str .= $page == $i ? " selected='true'" : '';
            $str .= ">$i</option>";
        }

        if ($count > 1)
        {
            $str .= "<option value='$count'";
            $str .= $page == $count ? " selected='true'" : '';
            $str .= ">$count</option>";
        }
    }

    return $str;
}
*/
?>