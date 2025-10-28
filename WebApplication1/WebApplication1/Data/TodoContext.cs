using Microsoft.EntityFrameworkCore;

namespace WebApplication1.Data;

public class TodoContext : DbContext
{
    public TodoContext(DbContextOptions<TodoContext> options) : base(options)
    {
    }
    
}