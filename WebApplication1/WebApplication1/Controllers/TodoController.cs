using Microsoft.AspNetCore.Mvc;

namespace WebApplication1.Controllers;

[ApiController]
[Route("[controller]")]
public class TodoController : Controller
{
    // GET
    public IActionResult Index()
    {
        return Ok("<div>Hello World</div>");
    }
}