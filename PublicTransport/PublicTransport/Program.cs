using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using Scalar.AspNetCore;

namespace PublicTransport;

public class Program
{
    public static void Main(string[] args)
    {
        var builder = WebApplication.CreateBuilder(args);

        // Add services to the container.

        builder.Services.AddControllers();
        
        builder.Services.AddRazorPages();
        
        builder.Services.AddHttpClient("PublicTransportApi", client =>
        {
            client.BaseAddress = new Uri("http://localhost:5124/"); 
            
        });

        // Learn more about configuring OpenAPI at https://aka.ms/aspnet/openapi
        builder.Services.AddOpenApi();

        builder.Services.AddDbContext<AppDbContext>(options =>
            options.UseSqlite(builder.Configuration.GetConnectionString("DefaultConnection")));
        
        var app = builder.Build();

        // Configure the HTTP request pipeline.
        if (app.Environment.IsDevelopment())
        {
            app.MapOpenApi();
            app.MapScalarApiReference();
            app.UseExceptionHandler("/Error");
        }


        app.UseHttpsRedirection();

        app.UseAuthorization();
        
        app.UseStaticFiles();
        app.UseRouting();

        app.MapRazorPages();


        app.MapControllers();

        app.Run();
    }
}