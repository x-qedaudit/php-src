--TEST--
GPC nested arrays built with singleton hashtables
--GET--
a[x][y]=1&a[x][z]=2&b[]=1&b[]=2&b[]=3&c[][][]=3&d[k]=v
--COOKIE--
ck[a][b]=1;ck[a][c]=2
--FILE--
<?php
echo json_encode($_GET), "\n", json_encode($_COOKIE), "\n";
for ($i = 0; $i < 1000; $i++) { $_GET['a']['x']["k$i"] = $i; $_GET['b'][] = $i; }
var_dump(count($_GET['a']['x']), count($_GET['b']), $_GET['a']['x']['k999'], $_GET['b'][1002]);
unset($_GET['a']['x']['y']);
var_dump(isset($_GET['a']['x']['z']), array_sum($_GET['b']));
$copy = $_GET; $copy['d']['k2'] = 1; var_dump(count($_GET['d']), count($copy['d']));
?>
--EXPECT--
{"a":{"x":{"y":"1","z":"2"}},"b":["1","2","3"],"c":[[["3"]]],"d":{"k":"v"}}
{"ck":{"a":{"b":"1","c":"2"}}}
int(1002)
int(1003)
int(999)
int(999)
bool(true)
int(499506)
int(1)
int(2)
