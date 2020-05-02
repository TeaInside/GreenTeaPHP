
<?php CPPClass::startHeader(__FILE__); ?>

namespace App::GreenTea::Controllers {

class Index
{
private:
  route_pass &r;
public:
  Index(route_pass &r);
  bool hello();
  bool query_string();
  bool call_php_func();
  bool php_global_var();
};

} // namespace App::GreenTea::Controllers

<?php CPPClass::endHeader(__FILE__); ?>
