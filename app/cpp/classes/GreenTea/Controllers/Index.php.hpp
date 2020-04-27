
<?php CPPClass::startHeader(__FILE__); ?>

namespace App::GreenTea::Controllers {

class Index
{
private:
  route_pass &r;
public:
  Index(route_pass &r);
  bool hello();
  bool queryString();
  bool dumpQueryString();
};

} // namespace App::GreenTea::Controllers

<?php CPPClass::endHeader(__FILE__); ?>
